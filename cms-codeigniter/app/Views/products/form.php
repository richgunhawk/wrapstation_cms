<?= $this->extend('products/layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1><p class="lede">Keep the catalog accurate so customers always see a clear price and stock count.</p>
<?php if (session()->getFlashdata('error')): ?><div class="notice error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form method="post" action="<?= $product ? site_url('products/'.$product['product_id']) : site_url('products') ?>">
    <label for="product_name">Product name</label>
    <div style="display:flex;gap:8px"><input id="product_name" name="product_name" required maxlength="160" value="<?= esc(old('product_name', $product['product_name'] ?? '')) ?>"><button class="btn secondary" type="button" id="scan-fruit">Start scan</button><button class="btn danger" type="button" id="stop-scan" hidden>Stop</button></div>
    <div class="camera-settings">
        <label for="camera_resolution">Camera resolution</label>
        <select id="camera_resolution"><option value="640x480">640 x 480</option><option value="1280x720" selected>1280 x 720</option><option value="1920x1080">1920 x 1080</option></select>
        <label for="camera_shutter">Shutter speed / exposure</label>
        <input id="camera_shutter" type="range" min="-11" max="-1" value="-6"><span id="camera_shutter_value">-6</span>
        <label for="camera_iso">ISO</label>
        <select id="camera_iso"><option value="auto">Auto</option><option value="100">100</option><option value="200">200</option><option value="400">400</option><option value="800">800</option></select>
        <p class="stock">Resolution is applied directly. Shutter speed and ISO are requested only when the browser and webcam support them.</p>
    </div>
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
const resolution = document.getElementById('camera_resolution');
const shutter = document.getElementById('camera_shutter');
const shutterValue = document.getElementById('camera_shutter_value');
const iso = document.getElementById('camera_iso');
let cameraStream = null;
let scanning = false;

shutter.addEventListener('input', () => { shutterValue.textContent = shutter.value; });

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
        const [width, height] = resolution.value.split('x').map(Number);
        cameraStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment', width: { ideal: width }, height: { ideal: height } } });
        const track = cameraStream.getVideoTracks()[0];
        const advanced = [{ exposureTime: Number(shutter.value) }];
        if (iso.value !== 'auto') advanced[0].iso = Number(iso.value);
        try { await track.applyConstraints({ advanced }); } catch (_) { }
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
