# CodeIgniter 4 CMS - Wrapstation Shop

CMS ini mensimulasikan pembelian produk tanpa authentication. Fitur: CRUD produk (create, read, update, delete), katalog stok, dan transaksi pembelian yang mengurangi stok di dalam database transaction. Skema mengikuti tiga tabel: `users`, `products`, `transactions`.

## Setup

1. Pastikan PHP 8.2+, extension `intl`, `mbstring`, `mysqli`, `json`, Composer, dan MySQL/MariaDB tersedia. Pada XAMPP Windows, buka `C:\xampp\php\php.ini`, ubah `;extension=intl` menjadi `extension=intl`, lalu tutup dan buka kembali terminal. Verifikasi dengan `php -m | Select-String intl`.
2. Dari folder ini, install dependency: `composer install`.
3. Salin `env` menjadi `.env`, lalu set `CI_ENVIRONMENT = development`, `app.baseURL`, serta koneksi `database.default.*` (hostname, database, username, password, DBDriver `MySQLi`). Buat database kosong terlebih dahulu.
4. Jalankan migration dan seed demo:

```powershell
php spark migrate
php spark db:seed ShopSeeder
php spark serve
```

Buka `http://localhost:8080`. Tombol `Add product`, `Edit`, `Delete`, dan `Buy` mendemonstrasikan seluruh alur CRUD/pembelian. Untuk database SQLite, ubah driver dan nama database pada `.env`; migration tetap sama.
