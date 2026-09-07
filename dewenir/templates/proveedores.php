<?php
if (!empty($posts)): ?>
    <div class="container-tarjetas-proveedores">
        <div class="tarjetas-disponibles"><?php _e('Marcas disponibles', 'dewenir') ?></div>
        <div class="container-proveedores">
            <?php foreach ($posts as $post): ?>
                <?php
                $tituloProveedor = $post->post_title;
                $img = get_field('img', $post->ID);
                ?>

                <div class="card-proveedor">
                    <div class="container-img-proveedor">
                        <img class="img-proveedor" src="<?= $img['url']; ?>" alt="<?php echo $tituloProveedor; ?>">
                    </div>
                    <p class="nombre-proveedor"><?= $tituloProveedor; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>