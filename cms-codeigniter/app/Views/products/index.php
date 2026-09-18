<?= $this->extend('products/layout') ?>
<?= $this->section('content') ?>
<h1>Fruit & essentials, ready to ship.</h1>
<p class="lede">CMS pembelian sederhana dengan alur katalog, stok, dan transaksi. Semua perubahan tersimpan melalui CodeIgniter 4 dan database relasional.</p>
<?php if (session()->getFlashdata('message')): ?><div class="notice"><?= esc(session()->getFlashdata('message')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="notice error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="toolbar"><h2>Product catalog</h2><div class="actions"><a class="btn secondary" href="<?= site_url('products/new?scan=1') ?>">Scan fruit camera</a><a class="btn" href="<?= site_url('products/new') ?>">+ Add product</a></div></div>
<div class="grid">
<?php foreach ($products as $product): ?>
    <article class="card"><h2><?= esc($product['product_name']) ?></h2><div class="price">Rp <?= number_format((float) $product['price'], 0, ',', '.') ?></div><div class="stock"><?= esc($product['qty_in_stock']) ?> unit in stock</div><div class="actions"><a class="btn" href="<?= site_url('products/'.$product['product_id'].'/buy') ?>">Buy</a><a class="btn secondary" href="<?= site_url('products/'.$product['product_id'].'/edit') ?>">Edit</a><form style="padding:0;border:0;background:transparent;box-shadow:none" method="post" action="<?= site_url('products/'.$product['product_id'].'/delete') ?>"><button class="btn danger" type="submit" onclick="return confirm('Delete this product?')">Delete</button></form></div></article>
<?php endforeach; ?>
</div>
<?= $this->endSection() ?>
