<?php
if (!have_rows('codigos_canjeados', $cliente->ID)) {
    $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language;
    echo ("<script>window.location.href = '" . $redirect . "'</script>");
    exit;
}

$cuponesCanjeados = [];
?>

<div class="cupones-canjeados-container">
    <?php while (have_rows('codigos_canjeados', $cliente->ID)) : the_row();
        $proveedoresClientes = get_sub_field('proveedor_codigo');
        $proveedor = reset($proveedoresClientes);

        $codigo = get_sub_field('codigo');
        $img = get_field('img', $proveedor->ID);
        $valorCupon = get_sub_field('valor_codigo');

        //manual por país
        $manual = dewenir_get_manual_por_pais($proveedor->ID, get_field('pais', $cliente->ID));
        //manual por país


        $post_title = get_the_title($proveedor->ID);

        $cuponesCanjeados[$codigo] = [
            'codigo' => $codigo,
            'proveedor' => $post_title,
            'manual' => $manual,
            'valor' => $valorCupon
        ];
    ?>

        <div class="cupon-canjeado">
            <div class="proveedor-descuento-container">
                <div class="proveedor-container">
                    <img src="<?= $img['url'] ?>" alt="confeti">
                    <div class="proveedor"><?= $post_title ?></div>
                </div>

                <div class="tu-descuento-container">
                    <div class="tu-descuento-texto"><?php _e('Tu descuento:', 'dewenir'); ?></div>
                    <div class="tu-descuento"><?= $valorCupon; ?><?= getCurrency($_SESSION['user_country']); ?></div>
                </div>
            </div>

            <div class="cupon-container">
                <?php if (str_contains($codigo, 'http')): ?>
                    <div class="accede-texto"><?php _e('Accede a tu descuento:', 'dewenir'); ?></div>
                    <a class="cupon-codigo-enlace" href="<?= $codigo ?>"><?= $codigo ?></a>
                <?php else: ?>
                    <div class="cupon-btn-container">
                        <div class="cupon-codigo-texto"><?= $codigo ?></div>
                        <button class="btn-copiar"><img src="https://www.kaspersky-gifts.com/wp-content/uploads/2024/11/icon-clipboard.svg" alt="<?php _e('Boton copiar en el portapapeles', 'dewenir') ?>"></button>
                    </div>
                    <?php if (!empty($manual)) : ?>
                        <div class="enlace-manual">
                            <a href="<?= $manual ?>" target="_blank"><?php _e('Descarga el manual de instrucciones', 'dewenir'); ?>

                                <?php

                                // if ($_SERVER['REMOTE_ADDR'] == '83.173.144.19') {
                                //     var_dump($cliente->pais);
                                // }
                                ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<!-- <form method="POST" class="envio-formulario">
    <div class="enviamos-correo-texto"><?php _e('Te los enviamos al correo', 'dewenir'); ?></div>
    <div class="envio-correo-container">
        <input
            type="email"
            name="email"
            placeholder="<?php _e('Introduce tu correo', 'dewenir') ?>"
            required>

        <button type="submit"><?php _e('Enviar', 'dewenir'); ?></button>
    </div>
</form> -->

<?php
if (!have_rows('codigos_canjeados', $cliente->ID)) {
    $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language;
    echo ("<script>window.location.href = '" . $redirect . "'</script>");
    exit;
}

$cuponesCanjeados = [];

while (have_rows('codigos_canjeados', $cliente->ID)) : the_row();
    $proveedoresClientes = get_sub_field('proveedor_codigo');
    $proveedor = reset($proveedoresClientes);

    $codigo = get_sub_field('codigo');
    $img = get_field('img', $proveedor->ID);
    $valorCupon = get_sub_field('valor_codigo');
    // $manual = get_field('manual', $proveedor->ID);
    $post_title = get_the_title($proveedor->ID);

    $cuponesCanjeados[] = [
        'codigo' => $codigo,
        'proveedor' => $post_title,
        'manual' => $manual,
        'valor' => $valorCupon
    ];
endwhile;
?>

<!-- Enviar Correo -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (!empty($email) && is_email($email)) {
        ob_start();
        include 'template-email.php';
        $message = ob_get_clean();

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        if (wp_mail($email, __('Cupones Canjeados', 'dewenir'), $message, $headers)) {
            echo '<p class="cupon-alerta">' . __('Cupones enviados.', 'dewenir') . '</p>';
        } else {
            echo '<p class="cupon-alerta">' . __('Hubo un error al enviar el correo.', 'dewenir') . '</p>';
        }
    } else {
        echo '<p class="cupon-alerta">' . __('Por favor, proporciona un correo válido.', 'dewenir') . '</p>';
    }
}
?>