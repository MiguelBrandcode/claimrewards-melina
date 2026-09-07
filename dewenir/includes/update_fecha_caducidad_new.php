<?php

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/update-fecha-caducidad-new', array(
        'methods' => ['POST'],
        'callback' => 'update_fechas_cliente',
        'permission_callback' => '__return_true',
    ));
});

function update_fechas_cliente($request)
{
    // Decodificar JSON si viene raw
    $params = $request->get_json_params();
    $nombre = $params['nombre'] ?? null;
    $fecha_ingreso = $params['fecha_ingreso'] ?? null;
    $fecha_caducidad = $params['fecha_caducidad'] ?? null;

    if (!$nombre || !$fecha_ingreso || !$fecha_caducidad) {
        return ['error' => 'Faltan datos'];
    }

    // Buscar cliente por título
    $cliente_query = new WP_Query(array(
        'post_type'      => 'cliente',
        'post_status'    => 'publish',
        'title'          => $nombre,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    if (empty($cliente_query->posts)) {
        return ['error' => 'Cliente no encontrado'];
    }

    $cliente_id = $cliente_query->posts[0];

    // Normalizar fechas
    $fecha_ingreso_obj = DateTime::createFromFormat('d/m/Y', $fecha_ingreso);
    $fecha_caducidad_obj = DateTime::createFromFormat('d/m/Y', $fecha_caducidad);

    if (!$fecha_ingreso_obj || !$fecha_caducidad_obj) {
        return ['error' => 'Formato de fecha inválido'];
    }

    $fecha_ingreso_formateada = $fecha_ingreso_obj->format('Y-m-d');
    $fecha_caducidad_formateada = $fecha_caducidad_obj->format('Y-m-d');

    // Actualizar campos
    update_field('fecha_ingreso', $fecha_ingreso_formateada, $cliente_id);
    update_field('fecha_caducidad', $fecha_caducidad_formateada, $cliente_id);

    return [
        'success' => true,
        'cliente' => $nombre,
        'fecha_ingreso' => $fecha_ingreso_formateada,
        'fecha_caducidad' => $fecha_caducidad_formateada,
    ];
}
