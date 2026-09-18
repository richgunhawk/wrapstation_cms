# CodeIgniter 4 CMS - Wrapstation Shop

This CMS provides product CRUD and a purchase flow that decreases stock in a database transaction. It uses the `users`, `products`, and `transactions` tables.

## Setup

1. Enable PHP extensions `intl`, `mbstring`, `mysqli`, and `json`.
2. Copy `env` to `.env` and configure `app.baseURL` plus the MySQL connection.
3. From this directory, run:

```powershell
composer install --no-dev
php spark migrate
php spark db:seed ShopSeeder
php spark serve
```

Open `http://localhost:8080` and test product create, read, update, delete, and purchase actions.
