<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        .email-container {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            max-width: 900px;
            width: 100%;
            display: block;
            margin: 90px auto;
            padding: 0 84px;
            box-sizing: border-box;
        }

        @media (max-width: 999px) {
            .email-container {
                padding: 0;
            }
        }

        .email-message {
            margin-bottom: 20px;
            font-size: 42px;
            font-weight: bold;
            line-height: normal;
            letter-spacing: 2.1px;
            text-align: center;
            color: #009881;
        }

        .email-message.email-instructions {
            margin-bottom: 50px;
            font-size: 24px;
            letter-spacing: normal;
        }

        .email-summary-title {
            margin-bottom: 6px;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.75px;
            text-align: left;
            color: #009881;
            display: block;
        }

        .email-divider {
            color: #009881;
            margin-bottom: 39px;
            border: none;
            border-top: 1px solid #009881;
        }

        .coupon-details {
            margin-bottom: 50px;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .coupon-provider {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #009881;
            text-align: center;
        }

        .coupon-value-text {
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #3e3e3e;
            text-align: center;
        }

        .coupon-value {
            color: #009881;
        }

        .coupon-code-label {
            margin-bottom: 13px;
            font-size: 14px;
            font-weight: bold;
            color: #3e3e3e;
            text-align: center;
        }

        .cupon-container {
            max-width: 470px;
            margin: 0 auto 15px;
        }

        .coupon-code-container {
            padding: 13px 60px;
            border-radius: 5px;
            background-color: #e0e0e0;
            text-align: center;
            max-width: 470px;
            overflow: hidden;
            overflow: auto;
        }

        .coupon-code-http {
            font-size: 16px;
            font-weight: 500;
            color: #009881 !important;
            text-decoration: underline;
            word-wrap: break-word;
            max-width: 470px;
        }

        .coupon-code {
            font-size: 18px;
            font-weight: normal;
            color: #707070;
            opacity: 1;
            max-width: 470px;
            word-wrap: break-word;
        }

        .coupon-manual {
            margin-top: 15px;
            font-size: 14px;
            font-weight: 300;
            text-align: center;
        }

        .coupon-manual-link {
            color: #3e3e3e !important;
            text-decoration: underline;
        }

        .email-button {
            margin-bottom: 29px;
            padding: 13px 35px;
            border-radius: 5px;
            box-shadow: 3px 3px 10px 0 rgba(0, 0, 0, 0.16);
            background: linear-gradient(to right, #82efa3 0%, #009881 100%);
            border: none;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
        }

        .email-button:hover {
            background: linear-gradient(to right, #5deb88 0%, #006657 100%);
        }

        .email-button-text {
            font-size: 18px;
            font-weight: bold;
            color: #fff !important;
            text-decoration: none;
        }

        .email-legal-text {
            font-size: 12px;
            font-weight: 300;
            line-height: 1.5;
            text-align: center;
            color: #3e3e3e;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-message-container">
            <div class="email-message email-success">¡Tu cupón ha sido canjeado exitosamente! 🎉</div>
        </div>
        <div class="email-message-container">
            <div class="email-message email-instructions">
                ¡Ya puedes disfrutar de tus recompensas en productos y servicios de tus marcas favoritas!
            </div>
        </div>
        <div class="email-summary-title-container">
            <div class="email-summary-title">RESUMEN</div>
        </div>
        <div class="email-divider-container">
            <hr class="email-divider">
        </div>
        <?php foreach ($cuponesCanjeados as $cupon): ?>
            <div class="coupon-details">
                <div class="coupon-provider">
                    <?= htmlspecialchars($cupon['proveedor']) ?>
                </div>
                <div class="coupon-value-text">
                    Descuento canjeado:
                    <span class="coupon-value">
                        <?= htmlspecialchars($cupon['valor']) ?><?php _e('€', 'dewenir'); ?>
                    </span>
                </div>
                <div class="cupon-container">
                    <?php if (str_contains($cupon['codigo'], 'http')): ?>
                        <div class="coupon-code-label">¡Aquí tienes tu enlace!</div>
                        <a href="<?= htmlspecialchars($cupon['codigo']) ?>" class="coupon-code-http">
                            <?= htmlspecialchars($cupon['codigo']) ?>
                        </a>
                    <?php else: ?>
                        <div class="coupon-code-label">¡Aquí tienes tu código!</div>
                        <div class="coupon-code-container">
                            <span class="coupon-code">
                                <?= htmlspecialchars($cupon['codigo']) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!str_contains($cupon['codigo'], 'http') && !empty($cupon['manual'])): ?>
                    <div class="coupon-manual">
                        <a href="<?= htmlspecialchars($cupon['manual']) ?>" class="coupon-manual-link">Descarga el manual de
                            instrucciones</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="email-button-container">
            <button class="email-button">
                <a class="email-button-text" href="https://www.kaspersky-gifts.com/es/gift-card/cart/confimation/">Ver en la web</a>
            </button>
        </div>
        <div class="email-legal-text-container">
            <div class="email-legal-text">
            </div>
        </div>
    </div>

</body>

</html>