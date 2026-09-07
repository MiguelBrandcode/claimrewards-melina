<?php

if (!isset($_SESSION['user'])) {
    rejectUser();
}

$args = array(
    'post_type'         => 'cliente',
    'title'             => $_SESSION['user'],
    'posts_per_page'    => 1,
    'post_status'       => 'publish',
);

$cliente = get_posts($args)[0];
$idCliente =  $cliente->ID;

$expiration_date = get_field('fecha_caducidad', $idCliente);

if (DateTime::createFromFormat('d/m/Y', $expiration_date) < new DateTime()) {
    rejectUser();
}

$response = postData();
$data = json_decode($response, true);
$cupones = [];

$paisFiltro = isset($paisCliente['value']) ? $paisCliente['value'] : $paisCliente;

foreach ($data as $cupon => $valorCod) {
    $partes = explode("-", $cupon);
    $pais = $partes[0];
    $grupo = $partes[1];
    $tipoCupon = $partes[2];
    $ano = $partes[3];

    if ($pais == $paisFiltro) {
        if (!isset($cupones[$grupo])) {
            $cupones[$grupo] = [];
        }

        if (!isset($cupones[$grupo][$tipoCupon])) {
            $cupones[$grupo][$tipoCupon] = [
                'pais' => $pais,
                'ano' => $ano,
                'cantidad' => $valorCod
            ];
        } else {
            $cupones[$grupo][$tipoCupon]['cantidad'] += $valorCod;
        }
    }
}

$datosProveedores = [];
foreach ($proveedores as $proveedor) {
    $nameKey = get_field('namekey', $proveedor->ID);
    $tituloProveedor = $proveedor->post_title;
    $img = get_field('img', $proveedor->ID);

    $datosProveedores[$nameKey] = [
        'title' => $tituloProveedor,
        'imgURL' => $img['url'],
    ];
}
?>


<?php
$error = false;
$error_text = "";

if (isset($_POST['enviar'])) {

    $saldoActualizado = 0;

    function validateOrder($data, $saldo, &$saldoActualizado, &$error, &$error_text)
    {
        $precioTotal = 0;
        $saldo = (float)$saldo;

        foreach ($_POST as $cod => $cantidadCupon) {
            $cantidadCupon = (int)$cantidadCupon;
            if ($cantidadCupon <= 0) {
                unset($_POST[$cod]);
                continue;
            }

            $partes = explode("-", $cod);
            $precio = (int)$partes[2];

            if (strpos($partes[2], '_') !== false) {
                $partes[2] = str_replace('_', '.', $partes[2]);
                $precio = (float)$partes[2];
                $cod = implode('-', $partes);
            }

            // if (strlen((string)$precio) === 3) {
            //     $precio = (float)(substr((string)$precio, 0, 2) . '.' . substr((string)$precio, 2, 1));
            // }

            if (!array_key_exists($cod, $data)) {
                return;
            }

            if ($cantidadCupon > $data[$cod]) {
                return;
            }

            $precioTotal += $precio * $cantidadCupon;
        }

        if ($saldo == 0 || $precioTotal > $saldo) {
            return;
        }

        $saldoActualizado = $saldo - $precioTotal;

        if (count($_POST) > 0) {
            postCupones($_POST, $saldoActualizado, $error, $error_text);
        }
    }

    function postCupones($cuponesSaneados, &$saldoActualizado, &$error, &$error_text)
    {
        $args = array(
            'post_type'         => 'cliente',
            'title'             => $_SESSION['user'],
            'posts_per_page'    => 1,
            'post_status'       => 'publish',
        );

        $cliente = get_posts($args);
        $idCliente =  $cliente[0]->ID;
        $client_name = $cliente[0]->post_title;

        foreach ($cuponesSaneados as $codCupon => $cantidad) {
            for ($i = 0; $i < $cantidad; $i++) {

                $partes = explode("-", $codCupon);

                if (strpos($partes[2], '_') !== false) {
                    $partes[2] = str_replace('_', '.', $partes[2]);
                    $codCupon = implode('-', $partes);
                }

                $licenceCode = getCupones($codCupon);

                if ($licenceCode == null) {
                    $error = true;
                    $error_text = __('Se ha producido un Error, Inténtelo más tarde.', 'dewenir');
                    return;
                }

                $args = array(
                    'post_type'         => 'proveedor',
                    'meta_key'      => 'namekey',
                    'meta_value'    => $partes[1],
                    'posts_per_page'    => 1,
                    'post_status'       => 'publish',
                );

                $proveedor = get_posts($args)[0];

                $valorCod = $partes[2];

                if (strpos($valorCod, '_') !== false) {
                    $valorCod = str_replace('_', '.', $valorCod);
                }

                // if (strlen($valorCod) === 3) {
                //     $valorCod = substr($valorCod, 0, 2) . '.' . substr($valorCod, 2, 1);
                // }

                $row = array(
                    'codigo' => $licenceCode,
                    'proveedor_codigo' => $proveedor,
                    'valor_codigo' => $valorCod,
                    'fecha_de_canjeo' => time(),
                );

                add_row('codigos_canjeados', $row, $idCliente);
            }
        }

        update_field('saldo_cliente', $saldoActualizado, $idCliente);

        $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language . '/gift-card/cart/confimation/';
        echo ("<script>window.location.href = '" . $redirect . "'</script>");
    }

    function getCupones($skuSingular)
    {
        $url = 'https://admin.singularmarketplace.com/api/v2/orders/';
        $data = [
            "product_sku" => $skuSingular,
            "first_name" => $_SESSION['user'],
            "last_name" => '',
            "email" => "orderID@redenciones.com",
            "website" => "Cupones"
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data)),
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language . '/codigos-descuento';
            echo ("<script>window.location.href = '" . $redirect . "'</script>");
            exit;
        }

        curl_close($ch);

        $decodedResponse = json_decode($response);

        $cupon = $decodedResponse->licence_code;

        return $cupon;
    }

    validateOrder($data, $saldo, $saldoActualizado, $error, $error_text);

    if ($error) {
        echo '
        <div id="errorModal" class="errorModal">
            <div class="modal-content">
                <div class="modal-text">' . $error_text . '</div>
                <div class="btn-container">
                    <button class="aceptar">' . __('Aceptar', 'dewenir') . '</button>
                </div>
            </div>
        </div>';
    }
}
?>

<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-text"><?php _e('¡No has canjeado tu cupón completo!', 'dewenir'); ?> <br>
            <?php _e('¿Estás seguro de que quieres continuar?', 'dewenir'); ?></div>
        <div class="btn-container">
            <button class="continuar"><?php _e('Continuar selección', 'dewenir'); ?></button>
            <button class="canjear"><?php _e('Canjear', 'dewenir'); ?></button>
        </div>
    </div>
</div>

<div class="container-form-cupones">
    <div class="col-container-carrito">
        <div class="container-carrito">
            <div class="tu-saldo row">
                <div><?php _e('Tu saldo: ', 'dewenir'); ?><br>
                    <div class="saldo-container">
                        <span class="saldo"><?= $saldo ?></span><span class="currency-simbol"><?= getCurrency($_SESSION['user_country']) ?></span>
                    </div>
                </div>
            </div>
            <div class="productos-carrito-container row">
                <div class="productos-carrito col">
                    <div class="producto col">
                        <?php _e('Producto', 'dewenir'); ?>
                        <div class="productos"></div>
                    </div>
                    <div class="uds col">
                        <?php _e('Uds.', 'dewenir'); ?>
                        <div class="unidades"></div>
                    </div>
                </div>
                <div class="total-carrito col">
                    <div class="container-total">
                        <?php _e('Total:', 'dewenir'); ?>
                        <div id="totalPrecio"></div>
                    </div>
                </div>
            </div>
            <div class="btn-canjear col">
                <button name="canjear" id="enviarBoton"><?php _e('Canjear', 'dewenir'); ?></button>
            </div>

            <?php if (have_rows('codigos_canjeados', $cliente->ID)) : ?>

                <div class="link-canjeados col">
                    <?php
                    $language = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
                    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $language . '/gift-card/cart/confimation/';
                    ?>
                    <a href="<?= $redirect ?>"><?php _e('Ver productos ya canjeados', 'dewenir') ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-container-cupones">
        <div class="container-cupones row">

            <?php

            if (empty($cupones)) {
                echo '<p class="empty-cupons">' . __('We currently do not have coupons for your country', 'dewenir') . '</p>';
            }

            ?>

            <form class="cuponForm" id="formularioCupones" action="" method="post">
                <?php foreach ($cupones as $namekey => $tiposCupon): ?>
                    <?php
                    $existeCantidad = false;
                    foreach ($tiposCupon as $cupon) {
                        if (!empty($cupon['cantidad'])) {
                            $existeCantidad = true;
                            break;
                        }
                    }

                    if (!$existeCantidad) {
                        continue;
                    }
                    ?>
                    <div class="container-cupon">

                        <div class="container-img-proveedor">
                            <img class="imagenCupon" src="<?= $datosProveedores[$namekey]['imgURL'] ?>" alt="imagen <?= $datosProveedores[$namekey]['title'] ?>">
                            <div class="grupoCupon"><?= $datosProveedores[$namekey]['title'] ?></div>
                        </div>

                        <div class="textoCantidad"><?php _e('Selecciona cantidad:', 'dewenir'); ?></div>

                        <?php foreach ($tiposCupon as $valorCodCupon => $datosCupon): ?>

                            <?php

                            $valorCodCuponDecimal = $valorCodCupon;

                            // if (strlen($valorCodCupon) === 3) {
                            //     $valorCodCuponDecimal = substr($valorCodCupon, 0, 2) . '.' . substr($valorCodCupon, 2, 1);
                            // }

                            ?>

                            <?php $id = "{$datosCupon['pais']}-$namekey-$valorCodCupon-{$datosCupon['ano']}"; ?>
                            <?php $disabled = $datosCupon['cantidad'] == 0; ?>

                            <?php if ($disabled) continue ?>

                            <div class="seleccionCupon">
                                <div class="clicable">
                                    <div class="checkbox-container">
                                        <input class="checkbox-tipoCupon<?php echo $disabled ? ' disabled-permanently' : ''; ?>" <?php if ($disabled) echo 'disabled'; ?> type="checkbox" data-tipoCupon="<?= $valorCodCuponDecimal ?>">
                                        <div class="punto-blanco"></div>
                                    </div>
                                    <div class="tipoCupon"><?php _e('Cupón de ', 'dewenir'); ?> <span class="precio-tipoCupon"><?= $valorCodCuponDecimal ?><?= getCurrency($_SESSION['user_country']) ?></span></div>
                                </div>

                                <select class="cantidadCupones" name="<?= $id ?>" id="select-<?= $namekey ?>-<?= $valorCodCupon ?>" disabled>
                                    <?php for ($i = 0; $i <= $datosCupon['cantidad']; $i++): ?>
                                        <option value="<?= $i ?>" data-cantidad="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <input type="hidden" name="enviar">
            </form>
        </div>
    </div>
</div>