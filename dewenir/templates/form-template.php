<?php

if (isset($_POST['form-submit'])) {
    createPosts($_POST['code-number'], $_POST['order-select']);
}
?>


<form action="" method="post" id="form_generator">
    <label for="code-number"><?php _e('Introduce el numero de códigos que desee generar', 'dewenir'); ?></label>
    <input type="number" id="code-number" name="code-number">
    <label for="order-select"><?php _e('Seleccione el origen', 'dewenir'); ?></label>
    <select name="order-select" id="order-select">
        <option value="netflix">Netflix</option>
        <option value="amazon">Amazon</option>
    </select>
    <input type="submit" value="Generar" name="form-submit">
</form>

<?php

$proveedores = get_field('Proveedores');

echo 'proveedores:' . var_dump($proveedores);
