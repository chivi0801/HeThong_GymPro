const video = document.getElementById('video');
const statusBox = document.getElementById('status');
const MODEL_URL = './models';
let detectTimer = null;

function setStatus(message) {
  if (statusBox) statusBox.textContent = message;
}

function showError(error, prefix = 'Loi') {
  console.error(error);
  const message = error && error.message ? error.message : String(error);
  setStatus(`${prefix}: ${message}`);
}

if (location.protocol === 'file:') {
  setStatus(
    'Ban dang mo bang file:// nen trinh duyet se chan load model.\n' +
    'Hay chay local server, vd: "python -m http.server 5500" roi vao http://localhost:5500'
  );
} else {
  boot();
}

async function boot() {
  try {
    setStatus('Dang tai model...');
    await Promise.all([
      faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
      faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
      faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
    ]);

    setStatus('Dang mo camera...');
    await startVideo();
    setStatus('Da mo camera. Dang nhan dien...');
  } catch (error) {
    showError(error, 'Khoi tao that bai');
  }
}

async function startVideo() {
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    throw new Error('Trinh duyet khong ho tro getUserMedia');
  }

  const stream = await navigator.mediaDevices.getUserMedia({
    video: { width: 720, height: 560 }
  });
  video.srcObject = stream;
}

video.addEventListener('play', () => {
  const oldCanvas = document.querySelector('canvas');
  if (oldCanvas) oldCanvas.remove();

  const canvas = faceapi.createCanvasFromMedia(video);
  video.parentElement.append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  if (detectTimer) clearInterval(detectTimer);
  detectTimer = setInterval(async () => {
    try {
      const detections = await faceapi.detectAllFaces(
      video,
      new faceapi.TinyFaceDetectorOptions()
    ).withFaceLandmarks()

      const resizedDetections = faceapi.resizeResults(detections, displaySize);

      canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
      faceapi.draw.drawDetections(canvas, resizedDetections);
      faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
    } catch (error) {
      showError(error, 'Loi khi nhan dien');
    }
  }, 120);
});

video.addEventListener('pause', () => {
  if (detectTimer) {
    clearInterval(detectTimer);
    detectTimer = null;
  }
});


//lưu khuôn mặt
let savedDescriptor = null

async function saveFace() {
  const detection = await faceapi.detectSingleFace(
    video,
    new faceapi.TinyFaceDetectorOptions()
  ).withFaceLandmarks().withFaceDescriptor()

  if (!detection) {
    alert("Không tìm thấy mặt!")
    return
  }

  savedDescriptor = detection.descriptor

  // Lưu vào localStorage (demo thôi)
  localStorage.setItem(
    "myFace",
    JSON.stringify(Array.from(savedDescriptor))
  )

  alert("Đã lưu khuôn mặt!")
}

//kiểm tra
async function checkFace() {

  const stored = localStorage.getItem("myFace")
  if (!stored) {
    alert("Chưa lưu khuôn mặt!")
    return
  }

  const saved = new Float32Array(JSON.parse(stored))

  const detection = await faceapi.detectSingleFace(
    video,
    new faceapi.TinyFaceDetectorOptions()
  ).withFaceLandmarks().withFaceDescriptor()

  if (!detection) {
    alert("Không tìm thấy mặt!")
    return
  }

  const distance = faceapi.euclideanDistance(
    saved,
    detection.descriptor
  )

  console.log("Distance:", distance)

  if (distance < 0.6) {
    alert("ĐÚNG NGƯỜI 😎")
  } else {
    alert("KHÔNG PHẢI 😢")
  }
}


//so sánh 2 khuôn mặt --------------------------
let uploadedDescriptor = null

document.getElementById('imageUpload')
.addEventListener('change', async (event) => {

  const file = event.target.files[0]
  const image = await faceapi.bufferToImage(file)

  const detection = await faceapi.detectSingleFace(
    image,
    new faceapi.TinyFaceDetectorOptions()
  ).withFaceLandmarks().withFaceDescriptor()

  if (!detection) {
    alert("Ảnh không có mặt!")
    return
  }

  uploadedDescriptor = detection.descriptor
  alert("Đã lấy khuôn mặt từ ảnh!")
})

// So sánh khuôn mặt đã lưu với khuôn mặt từ ảnh

async function compareWithCamera() {

  if (!uploadedDescriptor) {
    alert("Chưa upload ảnh!")
    return
  }

  const detection = await faceapi.detectSingleFace(
    video,
    new faceapi.TinyFaceDetectorOptions()
  ).withFaceLandmarks().withFaceDescriptor()

  if (!detection) {
    alert("Camera không thấy mặt!")
    return
  }

  const distance = faceapi.euclideanDistance(
    uploadedDescriptor,
    detection.descriptor
  )

  console.log("Distance:", distance)

  if (distance < 0.6) {
    alert("TRÙNG NGƯỜI 😎")
  } else {
    alert("KHÔNG TRÙNG 😢")
  }
}