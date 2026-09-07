<?php

/*
*	DEWENIR
*	CODIGO PERSONALIZADO
*/

// Add a filter to remove srcset attribute from generated <img> tag
add_filter('wp_calculate_image_srcset_meta', '__return_null');


// Remove portfolio post type and HOME slider
remove_action('init', 'portfolio_register');
remove_action('init', 'slider_register');


// Remove replace " to <<
add_filter('run_wptexturize', '__return_false');


add_action('wp_enqueue_scripts', 'dewenir_name_scripts');
function dewenir_name_scripts()
{
    /* Select2 */
    wp_enqueue_style('select2.min.css', get_theme_file_uri() . '/dewenir/libraries/select2/dist/css/select2.min.css', array(), '1.0.0', 'all');
    wp_enqueue_script('select2.min.js', get_theme_file_uri() . '/dewenir/libraries/select2/dist/js/select2.min.js', array(), '1.0.0', true);

    /* BOOTSTRAP*/
    // wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' );
    // wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js', array(), '1.0.0', true);

    /* ROBOTO */
    wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700', array(), '1.0.0', 'all');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Lato:300,400,700,900|Montserrat:300,400,500,600,700', array(), '1.0.0', 'all');

    /* MATERIAL ICONS */
    wp_enqueue_style('icon', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1.0.0', 'all');

    /* LESS */
    // wp_enqueue_script('less.min.js', get_template_directory_uri() . '/wp-less/less/less.min.js', array(), '1.0.0', true );

    wp_enqueue_script('api.js', 'https://www.google.com/recaptcha/api.js?render=6Lcz6JAqAAAAAEBOaSACUbMcdbdobVMAK94HYN7G', array(), '1.0.0', true);

    wp_enqueue_style('dewenir-less', get_template_directory_uri() . '/dewenir/css/dewenir.less', array(), '1.0.0', 'all');
    wp_enqueue_script('dewenir.js', get_template_directory_uri() . '/dewenir/js/dewenir.js', array(), '1.0.0', true);

    global $post;
    global $dewenir_clase_body;
    $dewenir_clase_body = get_post_meta($post->ID, 'dewenir_clase_body', true);
    if (!empty($dewenir_clase_body)) {

        // En caso de existir, asignamos fichero less de la pagina en cuestion
        $ruta_fichero = '/dewenir/css/' . $dewenir_clase_body . '.less';
        if (file_exists(get_template_directory() . $ruta_fichero)) {
            wp_enqueue_style($dewenir_clase_body, get_template_directory_uri() . $ruta_fichero, array(), '1.0.0', 'all');
        }

        // Asignamos clase al body en caso de tener campo custom
        add_filter('body_class', 'dewenir_clases_body');
    }

    /*
	if(get_post_type() == 'especiales'){
		wp_enqueue_script( 'masonry.js', get_template_directory_uri() . '/dewenir/plugins/masonry/masonry.pkgd.min.js', array(), '1.0.0' );
		wp_enqueue_script( 'dewenir_especiales.js', get_template_directory_uri() . '/dewenir/dewenir_especiales.js', array(), '1.0.0' );
	}
	*/
}

function dewenir_clases_body($classes)
{

    global $dewenir_clase_body;
    if ($dewenir_clase_body) $classes[] = $dewenir_clase_body;
    return $classes;
}

function dewenir_metabox_clase_body($post)
{

    /* BLOQUE PERSONALIZACION DEWENIR */
    add_meta_box(
        'bloque_customizacion_page_metabox',
        __('Este bloque únicamente se utiliza para labores internas del tema. NADIE ajeno al tema debería cambiar estos valores. De modificarlos el funcionamiento de la web podría variar.', 'salient'),
        'dewenir_clase_body_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dewenir_metabox_clase_body');

function dewenir_clase_body_meta_box_callback($post)
{
    wp_nonce_field('oe_post_nonce', 'oe_post_nonce');
?>
    <div class="elemento form-field">
        <label class="team-lbl" for=""><?php _e('Slug page type:', 'salient') ?></label>
        <div class="input">
            <input class="input-custom-field short" name="dewenir_clase_body" id="dewenir_clase_body" type="text" value="<?php echo get_post_meta($post->ID, 'dewenir_clase_body', true) ?>">
        </div>
    </div>

    <style type="text/css">
        .elemento {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .elemento .team-lbl {
            width: 100%;
        }

        .elemento .input {
            width: 100%;
        }

        .elemento .input input {
            width: 100%;
        }
    </style>
<?php
}

function dewenir_save_meta_box_data($post_id)
{

    if (isset($_POST['dewenir_clase_body']))
        update_post_meta($post_id, 'dewenir_clase_body', $_POST['dewenir_clase_body']);
}
add_action('save_post', 'dewenir_save_meta_box_data');

function register_my_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'register_my_session');

// function start_session_if_not_started()
// {
//     if (session_status() === PHP_SESSION_NONE) {
//         session_start();
//     }
// }

// // Hook para iniciar la sesión en la inicialización de WordPress
// add_action('init', 'start_session_if_not_started', 1);

// // Hook para asegurarse de que la sesión persiste en envíos de formularios
// add_action('wp_loaded', 'start_session_if_not_started');
add_action('template_redirect', function () {
    if (!isset($_GET['oid']) || empty($_GET['oid'])) return;

    $client = get_page_by_title($_GET['oid'], OBJECT, 'cliente');
    if (!$client) return;



    $client_id = $client->ID;
    $oid = strtoupper($client->post_name);
    $idioma_cliente = strtolower(get_field('pais', $client_id));



    if (strtolower($idioma_cliente) === 'uk') $idioma_cliente = 'en';
    if (strtolower($idioma_cliente) === 'pt' || strtolower($idioma_cliente) === 'pt-br') $idioma_cliente = 'pt-pt';



    if (empty($idioma_cliente)) {
        $idioma_cliente = 'en';
    }

    $languages = apply_filters('wpml_active_languages', NULL, []);
    $idiomas_disponibles = $languages ? array_keys($languages) : [];


    // por defecto, inglés
    if (!in_array($idioma_cliente, $idiomas_disponibles)) {
        $idioma_cliente = 'en';
    }

    $idioma_wp = $_COOKIE['wp-wpml_current_language'] ?? 'en';


    // Evitar redirección si ya estamos en la página gift-card con este oid
    if (is_page('gift-card') && isset($_GET['oid']) && $_GET['oid'] == $oid && (strtolower($idioma_cliente) == strtolower($idioma_wp))) return;


    // Solo redirigir si el idioma del cliente es diferente al actual
    if (strtolower($idioma_cliente) == strtolower($idioma_wp)) return;


    $url = apply_filters(
        'wpml_permalink',
        home_url('/gift-card/'), // solo la página
        strtolower($idioma_cliente)
    );

    // Añadir el oid como query param
    $url = add_query_arg('oid', $oid, $url);

    wp_redirect($url);
    exit;
});

/**
 * Devuelve el manual de instrucciones de un proveedor para el país del cliente.
 *
 * Requiere que exista en ACF, en el CPT "proveedor", un campo repetidor
 * llamado "manuales_por_pais" con dos subcampos: "pais" y "manual". Si ese
 * campo no está creado todavía (o no hay ninguna fila que coincida con el
 * país del cliente), se usa como fallback el campo "manual" general del
 * proveedor, que es el que se usa hoy para todos los países.
 *
 * @param int          $proveedor_id ID del post "proveedor".
 * @param string|array $pais_cliente Valor devuelto por get_field('pais', $cliente_id).
 * @return string Manual a mostrar (puede ser el general si no hay uno específico).
 */
function dewenir_normalizar_manual($manual)
{
    // Los campos de tipo "Archivo"/"Imagen" en ACF pueden devolver un array
    // (formato de retorno "Array" u "Objeto") en vez de una URL en texto.
    if (is_array($manual)) {
        return $manual['url'] ?? '';
    }

    return (string) $manual;
}

function dewenir_get_manual_por_pais($proveedor_id, $pais_cliente)
{
    $manual_general = dewenir_normalizar_manual(get_field('manual', $proveedor_id));

    $pais_cliente = is_array($pais_cliente) ? ($pais_cliente['value'] ?? '') : $pais_cliente;
    $pais_cliente = strtoupper(trim((string) $pais_cliente));

    if (empty($pais_cliente) || !have_rows('manuales_por_pais', $proveedor_id)) {
        return $manual_general;
    }

    while (have_rows('manuales_por_pais', $proveedor_id)) : the_row();
        $pais_fila = get_sub_field('pais');
        $pais_fila = is_array($pais_fila) ? ($pais_fila['value'] ?? '') : $pais_fila;
        $pais_fila = strtoupper(trim((string) $pais_fila));

        $manual_fila = dewenir_normalizar_manual(get_sub_field('manual'));

        if ($pais_fila === $pais_cliente && !empty($manual_fila)) {
            return $manual_fila;
        }
    endwhile;

    return $manual_general;
}
