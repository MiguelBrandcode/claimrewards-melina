<?php
$error = false;
$error_text = "";

function validate(&$error, &$error_text)
{
    $codCli = $_POST['order-id'];

    if (empty($codCli)) {
        $error = true;
        $error_text = __('El campo de pedido no puede estar vacío.', 'dewenir');
        return;
    }

    $postsCod = get_posts(
        array(
            'posts_per_page' => 1,
            'post_type' => 'cliente',
            'title' => $codCli,
            'post_status'    => array('publish', 'draft'),
        )
    );

    //VALIDAR SI EXISTE
    if (empty($postsCod)) {
        $error = true;
        $error_text = __(
            'Este código es incorrecto o desconocido. La información puede tardar hasta 15 minutos en actualizarse. Vuelva a intentarlo más tarde. Si el problema persiste, póngase en contacto con nosotros a través de nuestro formulario de contacto: <a href="https://kasperskynxw.zendesk.com/hc/es/requests/new" target="_blank">https://kasperskynxw.zendesk.com/hc/es/requests/new</a>',
            'dewenir'
        );
        return;
    }

    $client = reset($postsCod);

    //VALIDAR SI ESTA CANCELADO
    if ($client->post_status == 'draft') {
        $error = true;
        $error_text = __(
            'Esta cuenta ya no está disponible.',
            'dewenir'
        );
        return;
    }

    $pais = get_field('pais', $client->ID)['value'];

    //VALIDAR LA FECHA MINIMA DE ACCESO
    $initial_access_date = get_field('fecha_inicial_acceso', $client->ID);
    $expiration_date = get_field('fecha_caducidad', $client->ID);

    if (!empty($initial_access_date)) {
        $no_valid = new DateTime() < DateTime::createFromFormat('d/m/Y', $initial_access_date);

        if ($no_valid) {

            $error = true;
            $error_text = sprintf(
                __('Proximamente podrás acceder a solicitar tu tarjeta regalo. Recuerda que podrás acceder desde el %s hasta el %s, una vez pasado este periodo,  no podrás acceder a solicitarlo.', 'dewenir'),
                $initial_access_date,
                $expiration_date
            );
            return;
        }
    }

    //VALIDAR SI LA FECHA HA CADUCADO

    $is_lapsed = DateTime::createFromFormat('d/m/Y', $expiration_date) < new DateTime();

    $codigos = get_field('codigos_canjeados', $client->ID);

    if ($is_lapsed && empty($codigos)) {
        $error = true;
        $error_text = sprintf(
            __('Tu periodo de acceso para solicitar tu tarjeta regalo caducó el %s.', 'dewenir'),

            $expiration_date
        );

        return;
    } else if ($is_lapsed && !empty($codigos)) {
        //Si ha caducado pero ha canjeado códigos, le dejamos pasar
    }

    $country = get_field('pais', $client->ID);

    $_SESSION['user'] = $codCli;
    $_SESSION['user_country'] = is_array($country) ? $country['value'] : $country;

    if ($is_lapsed) {
        $_SESSION['is_lapsed'] = true;
    }

    $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];

    //VALIDAR SI SALDO ES 0 PARA REDIRIGIR A LA PAGINA DE CLAIMS
    $balance = get_field('saldo_cliente', $client->ID);

    if ($balance == '0' || ($is_lapsed && !empty($codigos))) {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language . '/gift-card/cart/confimation/';
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
    } else {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language . '/gift-card/cart/';
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
    }
}

if (isset($_POST['claim-submit'])) {
    validate($error, $error_text);
}

?>

<div class="text-canjealo"><?php _e('Oferta reservada a los clientes de Kaspersky', 'dewenir'); ?></div>

<form id="formularioCupones" method="post">
    <label class="text-numero-pedido" for="order-id"><?php _e('Número de pedido: ', 'dewenir'); ?></label>
    <input class="input-numero-pedido" type="text" id="order-id" name="order-id" value=""
        placeholder="<?php _e('Ej: HC23127986A', 'dewenir') ?>" required>
    <?php if ($error): ?>
        <p class="error-codee"> <?= $error_text ?> </p>
    <?php endif ?>

    <!-- Token reCAPTCHA -->
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

    <button class="button-form-submit" type="submit" name="claim-submit" value="Comprobar">
        <div class="submit-ico"></div>
    </button>
</form>



<?php

$message_date = true;

if ((isset($_GET['oid']) && !empty($_GET['oid']))) {

?>
    <div class="text-garantia-devolucion">

        <?php

        $client = get_page_by_title($_GET['oid'], OBJECT, 'cliente');

        if (!is_null($client)) {
            $client_id = $client->ID;
            $fecha_inicio = get_field('fecha_inicial_acceso', $client_id);
            $start_final = get_field('fecha_caducidad', $client_id);
            $message_date = true;
            // $oid = strtolower($client->post_title);
            /* redireccion idioma */
            // $idioma = get_field('pais', $client_id);

            echo sprintf(
                __('Tienes desde el %s hasta el %s para canjear el código.', 'dewenir'),
                $fecha_inicio,
                $start_final
            );

            // if ($_SERVER['REMOTE_ADDR'] == '83.173.144.19') {
            //     $languages = apply_filters('wpml_active_languages', NULL, []);
            //     $idiomas_disponibles = array_keys($languages);
            //     if (in_array(strtolower($idioma), $idiomas_disponibles)) {


            //     }
            // }
        }

        ?>
    </div>

<?php

}

?>