# IoT & Embedded Systems - Camera Controller

`camera_capture.py` uses OpenCV and the trained YOLO model to display a real-time webcam preview with fruit labels and save captures.

```powershell
cd iot-camera
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
python camera_capture.py
```

Controls: `C` saves one image, hold `B` to capture continuously, and `Q` or `Esc` exits. Burst capture stops as soon as `B` is released. Captures are stored in `captures/`. Camera index, resolution, FPS, auto-exposure, shutter speed, ISO, model path, and confidence are defined at the top of the script. Windows is required for physical key-release detection through the native keyboard API.
