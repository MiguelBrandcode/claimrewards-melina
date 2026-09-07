<?php

// AÑADIR CLIENTE
// [DEV] https://redenciones.dewenir.es/wp-json/wp/v2/pixel?sku=KL1047SDAFS&order=789456797
// [PROD] https://www.kaspersky-gifts.com/wp-json/wp/v2/pixel?sku=KL1047SDAFS&order=789456797

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/pixel', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'add_client',
        'args' => [
            'sku' => [
                'required' => true,
                'type' => 'string',
            ],
            'order' => [
                'required' => true,
                'type' => 'string',
            ],
        ]
    ));
});

// DAR DE BAJA CLIENTE
// [PROD] https://www.kaspersky-gifts.com/wp-json/wp/v2/pixel/cancel?order=789456797

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/pixel/cancel', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'cancel_client',
        'args' => [
            'order' => [
                'required' => true,
                'type' => 'string',
            ],
        ]
    ));
});

function get_client_balance($product)
{
    $product_id = $product->ID;

    $saldo_general = get_field('saldo_general', $product_id) ?? 0;
    $promociones = get_field('promociones', $product_id) ?? 0;

    if (empty($promociones)) {
        return $saldo_general;
    }

    $hoy =  strtotime('now');
    $saldo_promocion = '';

    foreach ($promociones as $promocion) {

        if (empty($promocion['fecha_desde'] || $promocion['fecha_hasta'])) {
            continue;
        }

        $fecha_desde = strtotime(DateTime::createFromFormat('d/m/Y', $promocion['fecha_desde'])->format('Y-m-d'));
        $fecha_hasta = strtotime(DateTime::createFromFormat('d/m/Y', $promocion['fecha_hasta'])->format('Y-m-d'));

        if ($hoy >= $fecha_desde && $hoy <= $fecha_hasta) {
            $saldo_promocion = $promocion['saldo_promocion'];
            break;
        }
    }

    // return !empty($saldo_promocion) ? (int) $saldo_promocion : (int) $saldo_general;
    return !empty($saldo_promocion) ? $saldo_promocion : $saldo_general;
}

function get_initial_access_date($start_expiration, $fechaIngreso = null)
{
    $start_expiration = !empty($start_expiration) ? $start_expiration : 0;

    if ($fechaIngreso) {
        $fecha_inicial_acceso = strtotime($fechaIngreso . "+" . $start_expiration . " days");
    } else {
        $fecha_inicial_acceso = strtotime("+" . $start_expiration . " days");
    }

    return $fecha_inicial_acceso;
}

function get_expiration_date($product_id, $start_expiration, $expiration, $fechaIngreso = null)
{
    // $days_expiration = intval($start_expiration) + intval($expiration);

    // if ($fechaIngreso) {
    //     $fecha_caducidad = strtotime($fechaIngreso . "+" . $days_expiration . " days");
    // } else {
    //     $fecha_caducidad = strtotime("+" . $days_expiration . " days");
    // }

    // if (empty($fecha_caducidad) || $fecha_caducidad == 0) {
    //     $fecha_caducidad = strtotime('+7 days');
    // }

    // return $fecha_caducidad;

    $fecha_caducidad = '';
    $days_expiration = intval($start_expiration) + intval($expiration);
    $promociones = get_field('promociones', $product_id) ?? 0;

    if (!empty($promociones)) {
        $hoy =  strtotime('now');

        foreach ($promociones as $promocion) {

            if (empty($promocion['fecha_desde'] || $promocion['fecha_hasta'])) {
                continue;
            }

            $fecha_desde = strtotime(DateTime::createFromFormat('d/m/Y', $promocion['fecha_desde'])->format('Y-m-d'));
            $fecha_hasta = strtotime(DateTime::createFromFormat('d/m/Y', $promocion['fecha_hasta'])->format('Y-m-d'));

            if ($hoy >= $fecha_desde && $hoy <= $fecha_hasta) {
                $fecha_caducidad = $fecha_hasta;
                break;
            }
        }
    }

    if (!empty($fecha_caducidad)) {
        return $fecha_caducidad;
    }

    if ($fechaIngreso) {
        $fecha_caducidad = strtotime($fechaIngreso . "+" . $days_expiration . " days");
    } else {
        $fecha_caducidad = strtotime("+" . $days_expiration . " days");
    }

    if (empty($fecha_caducidad) || $fecha_caducidad == 0) {
        $fecha_caducidad = strtotime('+7 days');
    }

    return $fecha_caducidad;
}

function get_product($sku)
{
    $posts = get_posts(array(
        'posts_per_page'    => -1,
        'post_type'     => 'producto',
        'meta_key'      => 'sku',
        'meta_value'    => $sku,
    ));

    return reset($posts);
}

function process_client_registration($sku, $order, $entryDate = null, $manual = false)
{

    require_once(ABSPATH . 'wp-admin/includes/post.php');

    if (post_exists($order)) {

        if ($manual) {
            return __('Rejected, customer already exists', 'dewenir');
        }

        return new WP_Error(
            'invalid_order',
            __('Rejected, customer already exists', 'dewenir'),
            array('status' => 400)
        );
    }

    if (!$manual) {
        $sku = urlencode($sku);
    }

    $product = get_product($sku);

    if (empty($product)) {

        if ($manual) {
            return __('Rejected, invalid SKU', 'dewenir');
        }

        return new WP_Error(
            'invalid_sku',
            __('Rejected, invalid SKU', 'dewenir'),
            array('status' => 400)
        );
    }

    $client = [
        'post_type' => 'cliente',
        'post_title'    => wp_strip_all_tags($order),
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
    ];

    $client_id = wp_insert_post($client);
    $product_id = $product->ID;
    $applicable = get_field('aplicable', $product_id);
    $country = get_field('pais', $product_id);
    $expiration = get_field('caducidad', $product_id);
    $start_expiration = get_field('inicio_caducidad', $product_id);

    $balance = $applicable ? get_client_balance($product) : 0;
    $fecha_inicial_acceso = get_initial_access_date($start_expiration, $entryDate);
    // $fecha_caducidad = get_expiration_date($start_expiration, $expiration, $entryDate);
    $fecha_caducidad = get_expiration_date($product_id, $start_expiration, $expiration, $entryDate);

    $date_of_entry = (isset($entryDate)) ? $entryDate : strtotime('now');

    update_field('sku', $sku, $client_id);
    update_field('pais', $country, $client_id);
    update_field('saldo_cliente', $balance, $client_id);
    update_field('fecha_ingreso', $date_of_entry, $client_id);
    update_field('fecha_inicial_acceso', $fecha_inicial_acceso, $client_id);
    update_field('fecha_caducidad', $fecha_caducidad, $client_id);

    if ($manual) {
        return __('Approved, registered customer', 'dewenir');
    }

    return [
        'code' => 'valid_order',
        'message' => __('Approved, registered customer', 'dewenir'),
        'data' => compact($ku, $order),
    ];
}

function process_client_cancel($order)
{
    $query = new WP_Query(array(
        'post_type'      => 'cliente',
        'posts_per_page' => 1,
        's'              => $order,
    ));

    $item = reset($query->posts);

    if (empty($item)) {
        return new WP_Error(
            'invalid_cancel_order',
            __('Rejected, that Order does not exist', 'dewenir'),
            array('status' => 400)
        );
    }

    $client_id = $item->ID;

    $update = array(
        'ID'          => $client_id,
        'post_status' => 'draft',
    );

    wp_update_post($update);

    return [
        'success'   => true,
        'code' => 'valid_order',
        'message' => __('Approved, customer canceled', 'dewenir'),
        'data' => compact($order),
    ];
}


// PIXEL URL
function add_client(WP_REST_Request $request)
{
    $sku = $request->get_param('sku');
    $order = $request->get_param('order');

    return process_client_registration($sku, $order);
}

// PIXEL MANUAL
function save_client($post)
{
    $sku = $_POST['sku'] . $_POST['pais'];

    $order = $_POST['order-id'];
    $entryDate = $_POST['entry-date'];

    return process_client_registration($sku, $order, $entryDate, true);
}

// CANCELAR CLIENTE
function cancel_client(WP_REST_Request $request)
{
    $order = $request->get_param('order');

    return process_client_cancel($order);
}
