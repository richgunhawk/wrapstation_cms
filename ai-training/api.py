"""Local HTTP inference API used by the CMS camera scanner."""
from pathlib import Path
import os
import tempfile

from flask import Flask, jsonify, request
from flask_cors import CORS
from ultralytics import YOLO

ROOT = Path(__file__).resolve().parent
MODEL_PATH = ROOT / "weights" / "best.pt"
model = YOLO(str(MODEL_PATH))
app = Flask(__name__)
CORS(app)


@app.post("/predict")
def predict():
    upload = request.files.get("image")
    if upload is None:
        return jsonify({"error": "image file is required"}), 400
    temporary_path = None
    try:
        with tempfile.NamedTemporaryFile(suffix=".jpg", delete=False) as temporary:
            temporary_path = temporary.name
            upload.save(temporary.name)
        result = model.predict(source=temporary_path, conf=0.10, verbose=False)[0]
    finally:
        if temporary_path:
            os.unlink(temporary_path)
    detections = []
    for box in result.boxes:
        class_id = int(box.cls[0])
        detections.append({
            "name": model.names[class_id],
            "confidence": round(float(box.conf[0]), 4),
        })
    detections.sort(key=lambda item: item["confidence"], reverse=True)
    return jsonify({"detections": detections, "top": detections[0] if detections else None})


if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5001, debug=False)
