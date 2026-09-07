<?php

function dewenir_ingresa_tu_codigo_form()
{
    include(locate_template('dewenir/templates/ingresa-tu-codigo-form.php'));
}

add_shortcode('dew_ingresa_tu_codigo_form', 'dewenir_ingresa_tu_codigo_form');

function dewenir_proveedores()
{
    $args = array(
        'post_type'         => 'proveedor',
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
        'suppress_filters'  => false,
    );

    $posts = get_posts($args);

    include(locate_template('dewenir/templates/proveedores.php'));
}

add_shortcode('dew_proveedores', 'dewenir_proveedores');

function dewenir_cupones_form()
{
    if (!isset($_SESSION['user'])) {
        $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language;
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
        exit;
    }

    $args = array(
        'post_type'         => 'cliente',
        'title'             => $_SESSION['user'],
        'posts_per_page'    => 1,
        'post_status'       => 'publish',
    );
    $clientes = get_posts($args);

    if (empty($clientes)) {
        $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language;
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
        exit;
    }

    $cliente = reset($clientes);
    $saldo = get_field('saldo_cliente', $cliente->ID);
    $paisCliente = get_field('pais', $cliente->ID);

    $args = array(
        'post_type'         => 'proveedor',
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
    );

    $proveedores = get_posts($args);

    include(locate_template('dewenir/templates/cupones-form.php'));
}

add_shortcode('dew_cupones_form', 'dewenir_cupones_form');

function dewenir_canjeado_exitosamente()
{
    $args = array(
        'post_type'         => 'proveedor',
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
    );

    $proveedores = get_posts($args);

    $args = array(
        'post_type'         => 'cliente',
        'title'             => $_SESSION['user'],
        'posts_per_page'    => 1,
        'post_status'       => 'publish',
    );

    $clientes = get_posts($args);
    $cliente = reset($clientes);

    if (!have_rows('codigos_canjeados', $cliente->ID)) {
        $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language;
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
        exit;
    }

    include(locate_template('dewenir/templates/canjeado-exitosamente.php'));
}

add_shortcode('dew_canjeado_exitosamente', 'dewenir_canjeado_exitosamente');

function dewenir_inicio()
{
    include(locate_template('dewenir/templates/inicio.php'));
}

add_shortcode('dew_inicio', 'dewenir_inicio');

function manual_pixel()
{
    include(locate_template('dewenir/templates/manual-pixel.php'));
}

add_shortcode('bc_manual_pixel', 'manual_pixel');