<?= $this->extend('products/layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1><p class="lede">Keep the catalog accurate so customers always see a clear price and stock count.</p>
<?php if (session()->getFlashdata('error')): ?><div class="notice error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form method="post" action="<?= $product ? site_url('products/'.$product['product_id']) : site_url('products') ?>">
    <label for="product_name">Product name</label>
    <div style="display:flex;gap:8px"><input id="product_name" name="product_name" required maxlength="160" value="<?= esc(old('product_name', $product['product_name'] ?? '')) ?>"><button class="btn secondary" type="button" id="scan-fruit">Start scan</button><button class="btn danger" type="button" id="stop-scan" hidden>Stop</button></div>
    <video id="fruit-camera" autoplay playsinline muted style="display:none;width:100%;margin-top:12px;border-radius:12px"></video>
    <p id="scan-status" class="stock">Start the local AI API, then scan a fruit to fill the name automatically.</p>
    <label for="qty_in_stock">Quantity in stock</label><input id="qty_in_stock" type="number" min="0" name="qty_in_stock" required value="<?= esc(old('qty_in_stock', $product['qty_in_stock'] ?? 0)) ?>">
    <label for="price">Price (IDR)</label><input id="price" type="number" min="0" step="0.01" name="price" required value="<?= esc(old('price', $product['price'] ?? '')) ?>">
    <div class="form-actions"><button class="btn" type="submit">Save product</button><a class="btn secondary" href="<?= site_url('/') ?>">Cancel</a></div>
</form>
<script>
const scanButton = document.getElementById('scan-fruit');
const stopButton = document.getElementById('stop-scan');
const video = document.getElementById('fruit-camera');
const status = document.getElementById('scan-status');
let cameraStream = null;
let scanning = false;

function stopCamera() {
    scanning = false;
    if (cameraStream) cameraStream.getTracks().forEach(track => track.stop());
    cameraStream = null;
    video.srcObject = null;
    video.style.display = 'none';
    scanButton.hidden = false;
    stopButton.hidden = true;
}

stopButton.addEventListener('click', () => {
    stopCamera();
    status.textContent = 'Scan stopped.';
});

scanButton.addEventListener('click', async () => {
    try {
        video.style.display = 'block';
        cameraStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
        video.srcObject = cameraStream;
        await video.play();
        scanning = true;
        scanButton.hidden = true;
        stopButton.hidden = false;
        status.textContent = 'Scanning... keep one fruit centered in the camera.';
        while (scanning) {
            if (video.videoWidth > 0 && video.videoHeight > 0) {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth; canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.9));
                const body = new FormData(); body.append('image', blob, 'camera.jpg');
                const response = await fetch('http://127.0.0.1:5001/predict', { method: 'POST', body });
                const result = await response.json();
                if (result.top) {
                    document.getElementById('product_name').value = result.top.name;
                    status.textContent = `${result.top.name} detected (${(result.top.confidence * 100).toFixed(1)}% confidence).`;
                    stopCamera();
                    break;
                }
                status.textContent = 'No fruit detected yet. Move the fruit closer and improve lighting.';
            }
            await new Promise(resolve => setTimeout(resolve, 900));
        }
    } catch (error) {
        stopCamera();
        status.textContent = `Scan failed: ${error.message}`;
    }
});

if (new URLSearchParams(window.location.search).get('scan') === '1') {
    scanButton.click();
}
</script>
<?= $this->endSection() ?>
