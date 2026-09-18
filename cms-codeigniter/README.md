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

## Camera fruit scanner

Run the local AI API in a second terminal:

```powershell
cd ..\ai-training
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
python api.py
```

Then open the CMS at `http://localhost:8080`, choose `Add product`, allow browser camera access, and click `Scan camera`. The browser captures one frame, sends it to the local YOLO API, and fills `Product name` with the detected class. The API must remain running while scanning.
