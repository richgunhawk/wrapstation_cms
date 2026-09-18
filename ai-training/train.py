"""Train a YOLO fruit detector from a local YOLO-format dataset."""
from pathlib import Path
import shutil

from ultralytics import YOLO

ROOT = Path(__file__).resolve().parent
DATASET_YAML = ROOT / "dataset" / "data.yaml"
BASE_MODEL = "yolo11n.pt"
EPOCHS = 50
IMAGE_SIZE = 640
BATCH_SIZE = -1
DEVICE = None


def main() -> None:
    if not DATASET_YAML.is_file():
        raise FileNotFoundError(
            f"Dataset YAML was not found: {DATASET_YAML}\n"
            "Download the Kaggle dataset, extract it into ai-training/dataset/, "
            "then set DATASET_YAML to the supplied YAML file."
        )

    model = YOLO(BASE_MODEL)
    results = model.train(
        data=str(DATASET_YAML), epochs=EPOCHS, imgsz=IMAGE_SIZE,
        batch=BATCH_SIZE, device=DEVICE, project=str(ROOT / "runs"),
        name="fruit_detector", exist_ok=True, pretrained=True,
        plots=True, patience=20, seed=42,
    )
    best_weight = Path(results.save_dir) / "weights" / "best.pt"
    final_weight = ROOT / "weights" / "best.pt"
    if not best_weight.is_file():
        raise FileNotFoundError(f"Training completed but weight was not found: {best_weight}")
    final_weight.parent.mkdir(parents=True, exist_ok=True)
    shutil.copy2(best_weight, final_weight)
    print(f"Training complete. Final weight copied to: {final_weight}")


if __name__ == "__main__":
    main()
