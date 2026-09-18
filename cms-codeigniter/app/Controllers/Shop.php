<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Shop extends BaseController
{
    public function buy(int $id): string
    {
        $product = (new ProductModel())->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
        }
        return view('products/buy', ['title' => 'Purchase Product', 'product' => $product, 'users' => (new UserModel())->findAll()]);
    }

    public function purchase(): RedirectResponse
    {
        $productModel = new ProductModel();
        $transactionModel = new TransactionModel();
        $data = $this->request->getPost(['user_id', 'product_id', 'payment_method', 'qty']);
        $product = $productModel->find((int) ($data['product_id'] ?? 0));
        $qty = (int) ($data['qty'] ?? 0);
        $userExists = (new UserModel())->find((int) ($data['user_id'] ?? 0));
        $validPayment = in_array($data['payment_method'] ?? '', ['Bank transfer', 'QRIS', 'Cash on delivery'], true);
        if (!$product || !$userExists || !$validPayment || $qty < 1 || $qty > (int) $product['qty_in_stock']) {
            return redirect()->back()->withInput()->with('error', 'Jumlah tidak valid atau stok tidak mencukupi.');
        }
        $db = db_connect();
        $db->transStart();
        $transactionModel->insert($data + ['total_price' => $qty * (float) $product['price']]);
        $productModel->update($product['product_id'], ['qty_in_stock' => $product['qty_in_stock'] - $qty]);
        $db->transComplete();
        return redirect()->to('/')->with('message', 'Pembelian berhasil dicatat.');
    }
}
