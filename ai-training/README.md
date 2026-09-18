# AI Training - Fruit Object Detection

## Setup

```powershell
cd ai-training
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
```

Download the Kaggle dataset, extract it into `dataset/`, and set `DATASET_YAML` in `train.py` to the supplied YAML file. The YAML must define the YOLO `train`, `val`, `test`, and `names` entries.

## Training

```powershell
python train.py
```

The best model is copied to `weights/best.pt`. The dataset and training runs are intentionally ignored by Git because they are large; evaluators can reproduce training by following this README.

## Inference

Place a test image at `images/test_fruits.jpg`, then run:

```powershell
python inference.py
```

The script prints detected classes and confidence values, then opens an OpenCV popup with bounding boxes and labels.
