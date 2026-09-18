# Full Stack Developer Technical Test - Wrapstation

## Spesifikasi sistem pengerjaan

| Item | Spesifikasi |
| --- | --- |
| Sistem operasi | Windows 11 Home Single Language, versi 10.0.26200, 64-bit |
| Perangkat | Acer Swift 3 Infinity 4 SF314-511 |
| Prosesor | Intel Core i5-1135G7, Intel Evo Platform, generasi ke-11 |
| RAM | 16 GB |
| Penyimpanan | SSD 512 GB |
| GPU | Intel Iris Xe Graphics (integrated) |
| Python | 3.9.0 terdeteksi saat inisialisasi proyek |
| PHP | XAMPP PHP 8.2+ diperlukan oleh CodeIgniter 4 |

## Verifikasi sebelum submission

1. Jalankan training AI dan commit `ai-training/weights/best.pt` (Git LFS bila ukuran file besar).
2. Ubah `IMAGE_PATH` pada `ai-training/inference.py` ke gambar uji yang valid, lalu ambil screenshot jendela deteksi.
3. Uji webcam melalui `iot-camera/camera_capture.py` dan pastikan hasil capture muncul di `iot-camera/captures/`.
4. Jalankan migration dan seeder CMS, kemudian uji tambah, edit, hapus produk serta pembelian.
5. Jalankan `git init`, commit seluruh source, lalu buat repository GitHub public.
# wrapstation_cms
