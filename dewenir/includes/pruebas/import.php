<?php

// [PROD] https://www.kaspersky-gifts.com/wp-json/wp/v2/import?sku=KL1047SDAFS&order=789456797&entryDate=2024/12/20 12:35 +01:00 (CET)

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/import', array(
        'methods' => 'GET',
        'callback' => 'import_client',
        'args' => [
            'sku' => [
                'required' => true,
                'type' => 'string',
            ],
            'order' => [
                'required' => true,
                'type' => 'string',
            ],
            'entryDate' => [
                'required' => true,
                'type' => 'string',
            ]
        ]
    ));
});

function import_get_client_balance($product)
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

    return !empty($saldo_promocion) ? (int) $saldo_promocion : (int) $saldo_general;
}

function import_get_expiration_date($start_expiration, $expiration, $fechaIngreso = null)
{
    $days_expiration = intval($start_expiration) + intval($expiration);

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

function import_get_product($sku)
{
    $posts = get_posts(array(
        'posts_per_page'    => -1,
        'post_type'     => 'producto',
        'meta_key'      => 'sku',
        'meta_value'    => $sku,
    ));

    return reset($posts);
}

function import_process_client_registration($sku, $order, $entryDate = null, $manual = false)
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

    $product = import_get_product($sku);

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

    // $client_id = wp_insert_post($client);
    $product_id = $product->ID;
    $applicable = get_field('aplicable', $product_id);
    $country = get_field('pais', $product_id);
    $expiration = get_field('caducidad', $product_id);
    $start_expiration = get_field('inicio_caducidad', $product_id);

    $balance = $applicable ? import_get_client_balance($product) : 0;
    $fecha_caducidad = import_get_expiration_date($start_expiration, $expiration, $entryDate);

    $date_of_entry = (isset($entryDate)) ? $entryDate : strtotime('now');

    update_field('sku', $sku, $client_id);
    update_field('pais', $country, $client_id);
    update_field('saldo_cliente', $balance, $client_id);
    update_field('fecha_ingreso', $date_of_entry, $client_id);
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

// PIXEL URL
function import_client(WP_REST_Request $request)
{
    $sku = $request->get_param('sku');
    $order = $request->get_param('order');
    $entryDate = $request->get_param('entryDate');

    return import_process_client_registration($sku, $order, $entryDate);
}
