"""Run fruit detection on a configured image and display the annotation popup."""
from pathlib import Path
import cv2
from ultralytics import YOLO

ROOT = Path(__file__).resolve().parent
MODEL_PATH = ROOT / "weights" / "best.pt"
IMAGE_PATH = ROOT / "images" / "test_fruits.jpg"
CONFIDENCE = 0.10
WINDOW_TITLE = "Fruit Detection - press any key to close"


def main() -> None:
    if not MODEL_PATH.is_file():
        raise FileNotFoundError(f"Model weight not found: {MODEL_PATH}. Run train.py first.")
    if not IMAGE_PATH.is_file():
        raise FileNotFoundError(f"Test image not found: {IMAGE_PATH}. Update IMAGE_PATH first.")
    model = YOLO(str(MODEL_PATH))
    result = model.predict(source=str(IMAGE_PATH), conf=CONFIDENCE, verbose=False)[0]
    print(f"Detections: {len(result.boxes)}")
    for box in result.boxes:
        class_id = int(box.cls[0])
        confidence = float(box.conf[0])
        print(f"- {model.names[class_id]}: {confidence:.2%}")
    annotated_image = result.plot()
    cv2.namedWindow(WINDOW_TITLE, cv2.WINDOW_NORMAL)
    cv2.imshow(WINDOW_TITLE, annotated_image)
    cv2.waitKey(0)
    cv2.destroyAllWindows()


if __name__ == "__main__":
    main()
