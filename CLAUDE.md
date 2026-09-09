# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Origin / project intent

This WordPress install (`claimrewards.brandcode.es`) is a **duplicate of
https://www.kaspersky-gifts.com/**, which lives on the same server under `/www`. The goal
of this duplicate is to stand up a new, independent rewards-claim portal reusing the same
Melina + `dewenir/` codebase — i.e. this is meant to become a *new client/brand* portal
built from the Kaspersky-gifts codebase, not a fork that stays in sync with it. When
comparing behavior or looking for reference implementation, the `/www` (kaspersky-gifts)
copy is the source of truth for "how the original worked"; branding, provider lists,
SKUs, and client-specific config in `dewenir/` here are expected to diverge over time as
this portal is customized for its own use case.

## Repository overview

This is a WordPress theme directory (`wp-content/themes/melina`), deployed at
`claimrewards.brandcode.es`. It is **not a standalone app** — there's no build step, no
package manager, no test runner. It's plain PHP that WordPress loads directly. There is
no local WordPress bootstrap in this repo; PHP files reference WP core functions
(`get_field`, `wp_enqueue_script`, `add_action`, etc.) that only resolve inside a running
WordPress + ACF (Advanced Custom Fields) installation.

The codebase is two layers glued together:

1. **Melina** — a purchased Themeforest blog/magazine theme (vendor code: `inc/`,
   `template-parts/`, `page-templates/`, `wp-less/`, `assets/`, root `*.php` template
   files, `style.css`). Treat this layer as third-party base theme code.
2. **`dewenir/`** — a large custom module bolted onto Melina that implements the actual
   business logic of this site: a **coupon/gift-code redemption and rewards platform**
   (client balances, providers, country/SKU-based coupon stock, redemption flows). This
   is where almost all real feature work happens. Spanish is used throughout for
   identifiers, comments, and admin labels (`cliente`, `proveedor`, `saldo`, `cupon`,
   `caducidad`).

There is no automated test suite, linter, or CI config in this repo. Verifying a change
means reading the PHP for correctness and, where possible, checking behavior against a
running WP install (e.g. via a staging/dev site) — there's no local `wp` CLI setup here.

## How the theme boots (`functions.php`)

`functions.php` is the entry point and wires everything together via `require`:

- Core theme setup: `melina_setup()`, widgets, nav menus, custom background/header.
- `inc/customizer/customizer.php` + `inc/color-scheme-css.php` — the Customizer-driven
  color scheme system (colors are chosen in wp-admin and compiled to CSS at runtime).
- `inc/template-tags.php`, `inc/template-functions.php`, `inc/template-hooks.php` — the
  theme's helper functions and the hook points templates render into.
- `inc/plugins/theme-required-plugins.php` — TGM Plugin Activation, declares required
  plugins.
- Conditional includes gated on `get_theme_mod(...)`: share buttons, contact form,
  Mailchimp, Instagram widget, WooCommerce integration (`inc/woocommerce/`).
- `wp-less/wp-less.php` — compiles `.less` files to CSS on the fly (no separate LESS
  build step; this is why you'll see `.less` files enqueued directly via
  `wp_enqueue_style`).
- **All of `dewenir/includes/*.php` is auto-loaded** via `glob()`:
  ```php
  foreach (glob(dirname(__FILE__) . '/dewenir/includes/*.php') as $filename) {
      require_once dirname(__FILE__) . '/dewenir/includes/' . basename($filename);
  }
  ```
  Any new file dropped into `dewenir/includes/` is picked up automatically — no need to
  add a `require` by hand. Files under `dewenir/includes/pruebas/` and
  `dewenir/includes/procesos/` are **not** auto-loaded by this glob (subdirectories are
  excluded) and are effectively scratch/scripts, not live code paths.

## The `dewenir/` module

Structure:
- `includes/functions.php` — misc setup: asset enqueueing (Select2, Google Fonts,
  Material Icons, reCAPTCHA, `dewenir.less`/`dewenir.js`), per-page LESS file loading via
  a `dewenir_clase_body` post meta field, removes core Melina portfolio/slider post
  types.
- `includes/shortcodes.php` — shortcodes that render `dewenir/templates/*.php`, e.g.
  `[dew_ingresa_tu_codigo_form]`, `[dew_proveedores]`, `[dew_cupones_form]`. These read
  from `$_SESSION['user']` for the logged-in "cliente" and redirect to the site root when
  no session/client is found.
- `includes/redention-functions.php` — the core redemption logic; talks to an external
  API at `admin.singularmarketplace.com` (coupon stock by SKU/country) and encodes a
  large static list of coupon SKUs (`ES-<BRAND>-<PERCENT>-<YEAR>`).
- `includes/pixel.php` — public REST endpoints under `wp/v2/pixel` (add/cancel a client
  by `sku`+`order`) used as a tracking pixel called by an external order system.
- `includes/import.php` — public REST endpoint `wp/v2/import` (`sku`, `order`,
  `entryDate`) to create/import a client record.
- `includes/admin.php` — wp-admin list-table customizations for the `cliente` CPT
  (extra sortable columns for país/SKU, both backed by ACF fields).
- `includes/update_fecha_caducidad*.php`, `includes/update_massive_change_balance.php`,
  `includes/udpate_fecha_inicio_process.php` — one-off/batch maintenance scripts for
  expiry dates and balances (check whether these are meant to run once vs. remain
  hooked — several are direct top-level code, not just function defs, so including this
  file executes it on every request unless guarded).
- `templates/` — the shortcode templates: coupon form, code-entry form, provider
  listing, redemption success page, email template.
- `data/countries.php`, `data/skus.php` — static lookup tables.
- CPTs referenced (`cliente`, `proveedor`) are **not registered anywhere in this repo** —
  they, and their ACF field groups (`saldo_cliente`, `pais`, `sku`, etc.), are assumed to
  be registered by an external plugin or ACF JSON sync, not by this theme. Check
  wp-admin / ACF field group export when you need the exact field schema.
- `libraries/` (select2, owlcarousel, viewportchecker, scrollmagic) are vendored
  third-party JS/CSS — don't hand-edit, replace wholesale if upgrading.

When working in `dewenir/`, prefer grepping for `get_field(` / ACF field names and
`$_SESSION['user']` to trace how client identity and data flow through the redemption
flow, since there's no schema file to read instead.

## Conventions to preserve

- New Melina-layer features are gated behind `get_theme_mod(...)` checks in
  `functions.php`, matching existing Customizer settings — follow that pattern rather
  than hard-coding feature includes.
- `dewenir` code is intentionally kept separate from the vendor theme files (`inc/`,
  root `*.php`) — put new custom/business logic in `dewenir/includes/` (auto-loaded) and
  new custom templates in `dewenir/templates/`, not in the vendor directories, so theme
  updates from the Melina vendor don't clobber it.
- Public REST endpoints in `dewenir` (`pixel.php`, `import.php`) are called by external
  systems with sku/order query params — check both `redenciones.dewenir.es` (dev) and
  the production domain comments at the top of those files before changing route shapes.
