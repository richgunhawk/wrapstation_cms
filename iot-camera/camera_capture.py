"""Live webcam preview with single and toggleable burst capture using OpenCV."""
from datetime import datetime
from pathlib import Path
import ctypes
import sys
import time
import cv2
from ultralytics import YOLO

CAMERA_INDEX = 0
FRAME_WIDTH = 1280
FRAME_HEIGHT = 720
FPS = 30
AUTO_EXPOSURE = True
SHUTTER_SPEED = -6
ISO = None
CAPTURE_DIRECTORY = Path(__file__).resolve().parent / "captures"
BURST_INTERVAL_SECONDS = 0.25
WINDOW_TITLE = "Camera Preview | hold B: burst | C: capture | Q/Esc: quit"
MODEL_PATH = Path(__file__).resolve().parent.parent / "ai-training" / "weights" / "best.pt"
DETECTION_CONFIDENCE = 0.10


def configure_camera(camera: cv2.VideoCapture) -> None:
    camera.set(cv2.CAP_PROP_FRAME_WIDTH, FRAME_WIDTH)
    camera.set(cv2.CAP_PROP_FRAME_HEIGHT, FRAME_HEIGHT)
    camera.set(cv2.CAP_PROP_FPS, FPS)
    camera.set(cv2.CAP_PROP_AUTO_EXPOSURE, 0.75 if AUTO_EXPOSURE else 0.25)
    if not AUTO_EXPOSURE:
        camera.set(cv2.CAP_PROP_EXPOSURE, SHUTTER_SPEED)
    if ISO is not None:
        camera.set(cv2.CAP_PROP_ISO_SPEED, ISO)


def save_frame(frame) -> Path:
    CAPTURE_DIRECTORY.mkdir(parents=True, exist_ok=True)
    output_path = CAPTURE_DIRECTORY / f"capture_{datetime.now():%Y%m%d_%H%M%S_%f}.jpg"
    if not cv2.imwrite(str(output_path), frame):
        raise RuntimeError(f"Could not save capture to {output_path}")
    print(f"Saved: {output_path}")
    return output_path


def burst_key_down() -> bool:
    if sys.platform == "win32":
        return bool(ctypes.windll.user32.GetAsyncKeyState(ord("B")) & 0x8000)
    return False


def main() -> None:
    backend = cv2.CAP_DSHOW if hasattr(cv2, "CAP_DSHOW") else cv2.CAP_ANY
    camera = cv2.VideoCapture(CAMERA_INDEX, backend)
    if not camera.isOpened():
        raise RuntimeError(f"Camera index {CAMERA_INDEX} cannot be opened.")
    configure_camera(camera)
    detector = YOLO(str(MODEL_PATH)) if MODEL_PATH.is_file() else None
    cv2.namedWindow(WINDOW_TITLE, cv2.WINDOW_NORMAL)
    last_burst_capture = 0.0
    try:
        while True:
            ok, frame = camera.read()
            if not ok:
                raise RuntimeError("Could not read a frame from the camera.")
            preview = frame.copy()
            if detector is not None:
                prediction = detector.predict(source=frame, conf=DETECTION_CONFIDENCE, verbose=False)[0]
                preview = prediction.plot()
            burst_enabled = burst_key_down()
            status = "BURST ON - release B to stop" if burst_enabled else "READY"
            cv2.putText(preview, status, (20, 40), cv2.FONT_HERSHEY_SIMPLEX,
                        1, (0, 0, 255) if burst_enabled else (0, 200, 0), 2)
            cv2.imshow(WINDOW_TITLE, preview)
            now = time.monotonic()
            if burst_enabled and now - last_burst_capture >= BURST_INTERVAL_SECONDS:
                save_frame(frame)
                last_burst_capture = now
            key = cv2.waitKey(1) & 0xFF
            if key in (ord("q"), 27):
                break
            if key in (ord("c"), ord("C")):
                save_frame(frame)
            if not burst_enabled:
                last_burst_capture = 0.0
    finally:
        camera.release()
        cv2.destroyAllWindows()


if __name__ == "__main__":
    main()
