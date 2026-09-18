# IoT & Embedded Systems - Camera Controller

`camera_capture.py` menggunakan OpenCV untuk membuka webcam, memberi live preview real-time, dan menyimpan gambar hasil capture.

```powershell
cd iot-camera
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
python camera_capture.py
```

`C` mengambil satu foto, `B` mengaktifkan/menonaktifkan burst capture, dan `Q` atau `Esc` menutup aplikasi. File disimpan ke `captures/` dengan timestamp unik. Konfigurasi kamera berada di bagian atas script. Dukungan exposure/ISO bergantung pada driver webcam.
