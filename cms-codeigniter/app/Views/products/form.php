<?= $this->extend('products/layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1><p class="lede">Keep the catalog accurate so customers always see a clear price and stock count.</p>
<?php if (session()->getFlashdata('error')): ?><div class="notice error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form method="post" action="<?= $product ? site_url('products/'.$product['product_id']) : site_url('products') ?>">
    <label for="product_name">Product name</label><input id="product_name" name="product_name" required maxlength="160" value="<?= esc(old('product_name', $product['product_name'] ?? '')) ?>">
    <label for="qty_in_stock">Quantity in stock</label><input id="qty_in_stock" type="number" min="0" name="qty_in_stock" required value="<?= esc(old('qty_in_stock', $product['qty_in_stock'] ?? 0)) ?>">
    <label for="price">Price (IDR)</label><input id="price" type="number" min="0" step="0.01" name="price" required value="<?= esc(old('price', $product['price'] ?? '')) ?>">
    <div class="form-actions"><button class="btn" type="submit">Save product</button><a class="btn secondary" href="<?= site_url('/') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
