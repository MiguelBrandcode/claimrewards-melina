<?php

// AÑADIR COLUMNAS POR ORDER
add_filter('manage_cliente_posts_columns', function ($columns) {

    $new_columns = [];

    foreach ($columns as $key => $column) {

        $new_columns[$key] = $column;

        if ($key == 'title') {
            $new_columns['country'] = __('País', 'dewenir');
            $new_columns['sku'] = __('SKU', 'dewenir');
        }
    }

    return $new_columns;
});

// AÑADIR DATOS A CADA COLUMNA
add_action('manage_cliente_posts_custom_column', function ($column_key, $post_id) {

    if ($column_key == 'country') {

        $value = get_field('pais', $post_id);
        $country = isset($value['value']) ? $value['value'] : $value;

        echo "<p>$country</p>";
    }

    if ($column_key == 'sku') {

        $sku = get_field('sku', $post_id);
        echo "<p>$sku</p>";
    }
}, 10, 2);

// HACER COLUMNA ORDENABLE
add_filter('manage_edit-cliente_sortable_columns', function ($columns) {

    // var_dump($columns);die;

    $columns['country'] = [
        'country',
        false,
        'Pais',
        'Tabla ordenada por pais'
    ];

    $columns['sku'] = [
        'sku',
        false,
        'SKU',
        'Tabla ordenada por SKU'
    ];

    return $columns;
});

// LOGICA DE ORDENACION PARA LAS NUEVAS COLUMNAS
add_action('pre_get_posts', function ($query) {

    if (!is_admin() || $query->get('post_type') !== 'cliente') {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'country') {
        $query->set('meta_key', 'pais');
        $query->set('orderby', 'meta_value');
    } elseif ($orderby === 'sku') {
        $query->set('meta_key', 'sku');
        $query->set('orderby', 'meta_value');
    }

    // AÑADIR CAMPOS PERSONALIZADOS EN EL BUSCADOR
    // $search_param = $query->get('s');

    // if ($search_param) {
    //     $query->set('s', '');

    //     $meta_query = [
    //         'relation' => 'OR',
    //         [
    //             'key' => 'pais',
    //             'value' => $search_param,
    //             'compare' => 'LIKE',
    //         ],
    //         [
    //             'key' => 'sku',
    //             'value' => $search_param,
    //             'compare' => 'LIKE',
    //         ],
    //     ];

    //     $query->set('meta_query', $meta_query);
    //     // var_dump($query);
    //     // die;
    // }
});
