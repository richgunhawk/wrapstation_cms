# Full Stack Developer Technical Test - Wrapstation

Richardus Sugeng Raharjo

## Spesifikasi sistem pengerjaan

Richardus Sugeng Raharjo

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

## AI training methodology

`ai-training/train.py` menggunakan Ultralytics YOLO11n pretrained sebagai object detector satu tahap untuk sembilan kelas buah. Pipeline training mencakup:

1. Dataset YOLO dari Kaggle dengan pasangan gambar dan label bounding box.
2. Validasi struktur dataset dan pemuatan label oleh Ultralytics.
3. Augmentasi bawaan YOLO selama training, termasuk mosaic, horizontal flip, HSV, dan RandAugment.
4. Transfer learning dari `yolo11n.pt`, kemudian fine-tuning selama 50 epoch pada resolusi 640.
5. Validasi pada split `val` setiap epoch dan penyimpanan bobot terbaik ke `ai-training/weights/best.pt`.
6. Pengujian inference melalui `ai-training/inference.py` pada gambar yang ditentukan di dalam script.

Evaluasi object detection tidak menggunakan accuracy klasifikasi biasa. Metrik yang relevan adalah precision, recall, F1-score, mAP50, dan mAP50-95. Hasil validasi terbaik yang tercatat pada `ai-training/runs/fruit_detector/results.csv` adalah:

| Metrik | Nilai |
| --- | ---: |
| Precision | 0.4384 |
| Recall | 0.6293 |
| mAP50 | 0.4006 |
| mAP50-95 | 0.2978 |

Nilai tersebut adalah baseline awal dari YOLO11n pada CPU dan belum tergolong tinggi. Confidence seperti `Apple 0.26` adalah keyakinan untuk satu prediksi, bukan accuracy keseluruhan model.

Arsitektur yang digunakan adalah YOLO11n (nano), yaitu detector CNN satu tahap dengan backbone untuk ekstraksi fitur, neck untuk penggabungan fitur multi-skala, dan detection head untuk memprediksi bounding box, kelas, serta confidence.

Dataset, folder hasil training, virtual environment, dan gambar lokal sengaja dikecualikan dari Git karena ukurannya besar. Evaluator dapat mengunduh dataset dan menjalankan ulang `train.py` mengikuti README pada `ai-training/`.
