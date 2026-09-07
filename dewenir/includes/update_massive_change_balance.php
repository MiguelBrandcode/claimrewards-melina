<?php

//https://www.kaspersky-gifts.com/wp-json/wp/v2/change-balance

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/change-balance', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'change_balance_process',
        'permission_callback' => '__return_true',
    ));
});

function change_balance_process()
{
    return;
    $per_page = 100;
    $paged = 1;

    do {
        $query = new WP_Query(array(
            'post_type'      => 'cliente',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'meta_query'     => array(
                array(
                    'key'     => 'sku',
                    'value'   => '143caf2e-8a63-4f59-8fe2-46bab54354df',
                    'compare' => '=',
                ),
            ),
            'fields'         => 'ids',
        ));

        foreach ($query->posts as $id) {

            $cliente = get_post($id);
            if ($cliente) {
                update_field('saldo_cliente', 109.90, $id);
            }
        }

        $paged++;
    } while ($paged <= $query->max_num_pages);
}
