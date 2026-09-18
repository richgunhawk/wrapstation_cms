<?= $this->extend('products/layout') ?>
<?= $this->section('content') ?>
<h1>Complete purchase</h1><p class="lede"><?= esc($product['product_name']) ?> · Rp <?= number_format((float) $product['price'], 0, ',', '.') ?> · <?= esc($product['qty_in_stock']) ?> available</p>
<?php if (session()->getFlashdata('error')): ?><div class="notice error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form method="post" action="<?= site_url('purchases') ?>">
    <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
    <label for="user_id">Customer</label><select id="user_id" name="user_id" required><?php foreach ($users as $user): ?><option value="<?= esc($user['user_id']) ?>"><?= esc($user['name']) ?></option><?php endforeach; ?></select>
    <label for="qty">Quantity</label><input id="qty" type="number" min="1" max="<?= esc($product['qty_in_stock']) ?>" name="qty" required value="1">
    <label for="payment_method">Payment method</label><select id="payment_method" name="payment_method" required><option>Bank transfer</option><option>QRIS</option><option>Cash on delivery</option></select>
    <div class="form-actions"><button class="btn" type="submit">Place order</button><a class="btn secondary" href="<?= site_url('/') ?>">Back</a></div>
</form>
<?= $this->endSection() ?>
