# Amro Chicken – QR Menu & Admin

Laravel 12 + Filament 4 menu for **عمرو تشكن (Amro Chicken)**, built from the QREXE menu
(`qr.algorexe.com/menu/amro-chicken`) and extended so a product can be sold **by quantity or by kilogram**.

- Public menu: `/` (redirects to `/menu/amro-chicken`)
- Admin dashboard: `/admin` (Businesses, Categories, Products, Garnishes, Offers, Customers, Users, Roles, Activity log, visit stats)
- QR code for the menu: `/generate-qr/amro-chicken`

## Selling by kilogram

Each product has a **Sold by** setting in the admin:

| Sold by | Price means | Customer picks |
|---|---|---|
| Quantity (piece / box) | price of one piece | how many |
| Weight (kilogram) | price of **1 kg** | a weight (default choices 0.2, 0.5, 1 kg, editable per product) and how many |

The cart and the WhatsApp order show the chosen weight, e.g. `جوانح  وزن 0.5 كغ  عدد 2`,
and the line total is `price per kg × weight × count`.

Columns added by `2026_11_17_000000_add_sale_type_to_products_table.php`: `sale_type` (`unit` | `weight`) and
`weight_options` (JSON list of kg values).

## Menu data

`database/data/amro-chicken-menu.json` holds the store, its 10 categories and 105 products as they appear on the
reference menu (products shown with "1 كيلو" there are imported as sold by weight).
`php artisan db:seed` imports it (safe to re-run; it updates rows in place) and creates the first admin.

Product images are referenced as `products/<file>.jpg` with thumbnails in `thumbnail/products/`, the same layout as
QREXE. Copy those two folders (and `businesses/`) from the QREXE `storage/app/public` into this app's
`storage/app/public`. They are served at `/media/...`.

## Setup

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env            # set APP_URL, DB_*, ADMIN_EMAIL, ADMIN_PASSWORD
php artisan key:generate
php artisan migrate --force
php artisan shield:generate --all --panel=admin --option=permissions
php artisan db:seed --force
php artisan storage:link        # public files are served from /media (the host blocks /storage)
```

The web root must point to `public/`.

Livewire's script is served as a static file from `public/livewire/livewire.min.js`, because this
host serves any URL ending in `.js` as a file and never passes it to PHP, and it blocks `/vendor/*`.
`composer install` copies the file there (see `post-autoload-dump` in `composer.json`). Do not run
`vendor:publish --tag=livewire:assets`: it makes Livewire point at `/vendor/livewire/...`, which is blocked.

On hosting where `.env` can't be edited directly, the app key can live in `storage/app/app_key`
(one line, `base64:...`; git-ignored) and `APP_URL` defaults to `https://amro-chicken.algorexe.com`.
