# AI Training - Fruit Object Detection

Implementasi ini memakai Ultralytics YOLO untuk mendeteksi dan mengklasifikasikan buah dalam gambar, lalu merender bounding box, confidence, dan nama kelas pada pop-up OpenCV.

## Setup

```powershell
cd ai-training
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
```

Unduh dataset sumber dari [Kaggle](https://www.kaggle.com/datasets/kapturovalexander/fruits-by-yolo-fruits-detection), ekstrak ke `ai-training/dataset/`, lalu temukan file YAML definisi dataset. Ubah konstanta `DATASET_YAML` di `train.py` agar menunjuk ke file tersebut. File YAML harus memetakan lokasi `train`, `val` (dan bila tersedia `test`) serta daftar nama kelas.

## Training dan hasil model

```powershell
python train.py
```

Hasil lengkap tersimpan pada `runs/fruit_detector/`; bobot terbaik otomatis disalin ke `weights/best.pt`. File `.pt` final wajib diunggah untuk submission dan sengaja tidak dikecualikan dari Git. Karena file model dapat besar, gunakan Git LFS bila ukurannya melebihi batas GitHub.

## Inference popup

Letakkan gambar uji di `images/test_fruits.jpg` atau ubah konstanta `IMAGE_PATH` pada `inference.py`, lalu jalankan `python inference.py`. Jendela pop-up akan menampilkan hasil dengan anotasi hasil deteksi. Tekan tombol apa pun untuk menutupnya.
