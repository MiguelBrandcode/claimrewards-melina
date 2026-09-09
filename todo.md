# TODO — Cambios de este portal respecto a kaspersky-gifts.com

Este portal (`claimrewards.brandcode.es`) parte del código de kaspersky-gifts.com.
Aquí se van apuntando las diferencias/cambios que debe tener este portal respecto al
original, a medida que se van decidiendo. Son solo anotaciones — no están implementadas
todavía.

## Reunión con Javi (2026-09-09)

- [x] Duplicar https://www.kaspersky-gifts.com/ con un nombre genérico (no ligado a
  Kaspersky).
- [x] Añadir un campo nuevo a 'Clientes' (CPT `cliente`) llamado **Partner**.
- [ ] La API del pixel (`dewenir/includes/pixel.php`) debe aceptar y pasar **Partner**
  además de SKU + Order ID.
- [ ] Modificar las peticiones a Singular (SingularMarketplace,
  `dewenir/includes/redention-functions.php` y `dewenir/templates/cupones-form.php`)
  para incluir también el **Partner**.
