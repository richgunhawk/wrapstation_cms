<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\RedirectResponse;

class Products extends BaseController
{
    private ProductModel $products;

    public function __construct()
    {
        $this->products = new ProductModel();
    }

    public function index(): string
    {
        return view('products/index', [
            'products' => $this->products->orderBy('product_id', 'DESC')->findAll(),
            'title' => 'Product Catalog',
        ]);
    }

    public function new(): string
    {
        return view('products/form', ['title' => 'Add Product', 'product' => null]);
    }

    public function create(): RedirectResponse
    {
        $data = $this->request->getPost(['product_name', 'qty_in_stock', 'price']);
        if (!$this->validateData($data, ['product_name' => 'required|max_length[160]', 'qty_in_stock' => 'required|is_natural', 'price' => 'required|decimal'])) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }
        $this->products->insert($data);
        return redirect()->to('/')->with('message', 'Product berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('products/form', ['title' => 'Edit Product', 'product' => $this->products->find($id)]);
    }

    public function update(int $id): RedirectResponse
    {
        $data = $this->request->getPost(['product_name', 'qty_in_stock', 'price']);
        if (!$this->validateData($data, ['product_name' => 'required|max_length[160]', 'qty_in_stock' => 'required|is_natural', 'price' => 'required|decimal'])) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }
        $this->products->update($id, $data);
        return redirect()->to('/')->with('message', 'Product berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $this->products->delete($id);
        return redirect()->to('/')->with('message', 'Product berhasil dihapus.');
    }
}
