<?php

$response = "";

if (isset($_POST['add-client-submit'])) {
    $response = save_client($_POST);
}

include(locate_template('dewenir/includes/data/countries.php'));

?>

<form id="manualPixel" method="POST">
    <label class="text-numero-pedido" for="order-id"><?php _e('Order: ', 'dewenir'); ?></label>
    <input class="input-numero-pedido" type="text" id="order-id" name="order-id" value="" required>

    <label class="text-sku" for="sku"><?php _e('SKU: ', 'dewenir'); ?></label>
    <input class="input-sku" type="text" id="sku" name="sku" value="" required>

    <label class="text-partner" for="partner"><?php _e('Partner: ', 'dewenir'); ?></label>
    <input class="input-partner" type="text" id="partner" name="partner" value="">

    <label class="text-pais" for="pais"><?php _e('Country: ', 'dewenir'); ?></label>
    <select name="pais" id="pais">

        <option value="default"></option>
        <option value="ES">Spain</option>
        <option value="FR">France</option>
        <option value="IT">Italy</option>
        <option value="DE">Germany</option>
        <option value="CAN">Canada</option>

    </select>

    <label for="fecha-ingreso"><?php _e('Date of entry: ', 'dewenir'); ?></label>
    <input type="date" id="entry-date" name="entry-date" value="" min="" max="" required />

    <?php if (!empty($response)): ?>
        <p class="response-container"> <?= $response ?> </p>
    <?php endif ?>

    <!-- Token reCAPTCHA -->
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

    <button class="button-form-submit" type="submit" name="add-client-submit"><?= _e('Register', 'dewenir');?></button>
</form>