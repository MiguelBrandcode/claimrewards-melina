<?php

//https://www.kaspersky-gifts.com/wp-json/wp/v2/process-caducidad

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/process-caducidad', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'fecha_caducidad_process',
        'permission_callback' => '__return_true',
    ));
});

function fecha_caducidad_process()
{
    $per_page = 50;
    $paged = 1;

    do {
        $query = new WP_Query(array(
            'post_type'      => 'cliente',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'meta_query' => array(
                array(
                    'key'     => 'pais',
                    'value'   => 'BR',
                    'compare' => '='
                ),
            ),
            'fields' => 'ids',
        ));

        foreach ($query->posts as $id) {

            $fecha_ingreso = get_field('fecha_ingreso', $id);
            $sku_cliente = get_field('sku', $id);

            if (!$sku_cliente) {
                continue;
            }

            $producto_query = new WP_Query(array(
                'post_type'      => 'producto',
                'posts_per_page' => 1,
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'     => 'sku',
                        'value'   => $sku_cliente,
                        'compare' => '=',
                    ),
                ),
                'fields' => 'ids',
            ));

            if (!empty($producto_query->posts)) {
                $producto_id = $producto_query->posts[0];

                $fecha_obj = DateTime::createFromFormat('d/m/Y h:i a', $fecha_ingreso);
                $fecha_ingreso_formateada = $fecha_obj ? $fecha_obj->format('d/m/Y') : null;

                $inicio_caducidad = get_field('inicio_caducidad', $producto_id);
                $inicio_caducidad = !empty($inicio_caducidad) ? (int)$inicio_caducidad : 0;
                $expiration = get_field('caducidad', $producto_id);
                $expiration = !empty($expiration) ? (int)$expiration : 0;
                $days = $inicio_caducidad + $expiration;

                $fecha_ingreso_normalizada = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_ingreso_formateada)));
                $fecha_caducidad = strtotime($fecha_ingreso_normalizada . " +" . $days . " days");

                update_field('fecha_caducidad', $fecha_caducidad, $id);
            }
        }

        $paged++;
    } while ($paged <= $query->max_num_pages);

    echo 'Finalizado';
    die;
}
