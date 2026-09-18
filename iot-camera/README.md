# IoT & Embedded Systems - Camera Controller

`camera_capture.py` uses OpenCV to display a real-time webcam preview and save captures.

```powershell
cd iot-camera
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
python camera_capture.py
```

Controls: `C` saves one image, `B` toggles burst capture, and `Q` or `Esc` exits. Captures are stored in `captures/`. Camera index, resolution, FPS, exposure, and ISO settings are defined at the top of the script.
