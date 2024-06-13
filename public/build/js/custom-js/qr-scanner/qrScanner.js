
    let currentStream;
    let currentCameraIndex = 0;
    let cameras = [];
    const videoElement = document.getElementById('preview');
    const canvasElement = document.getElementById('canvas');
    const canvasContext = canvasElement.getContext('2d');
    const qrResultElement = document.getElementById('qr-result-text');
    const messageElement = document.getElementById('message');
    const startCameraButton = document.getElementById('start-camera');
    const switchCameraButton = document.getElementById('switch-camera');
    const scanSection = document.getElementById('scan-section');
    const qrInputElement = document.getElementById('warehouseId');
    const verifyButton = document.getElementById('verifyButton');

    async function startCamera() {
    const devices = await navigator.mediaDevices.enumerateDevices();
    cameras = devices.filter(device => device.kind === 'videoinput');

    if (cameras.length > 0) {
    // Find the back camera, otherwise use the first camera
    currentCameraIndex = cameras.findIndex(camera => camera.label.toLowerCase().includes('back')) || 0;
    if (currentCameraIndex === -1) currentCameraIndex = 0;

    switchCamera();
    switchCameraButton.style.display = cameras.length > 1 ? 'inline' : 'none';
    videoElement.style.display = 'block';
    startCameraButton.style.display = 'none';
} else {
    console.error('No cameras found.');
}
}

    async function switchCamera() {
    if (currentStream) {
    currentStream.getTracks().forEach(track => track.stop());
}
    const camera = cameras[currentCameraIndex];
    currentCameraIndex = (currentCameraIndex + 1) % cameras.length;

    try {
    const stream = await navigator.mediaDevices.getUserMedia({
    video: {
    deviceId: camera.deviceId,
    width: {ideal: 1280},
    height: {ideal: 720}
}
});
    currentStream = stream;
    videoElement.srcObject = stream;
    videoElement.play();
    scanQRCode();
} catch (error) {
    console.error(error);
}
}

    function scanQRCode() {
    if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
    canvasElement.width = videoElement.videoWidth;
    canvasElement.height = videoElement.videoHeight;
    canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
    const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
    const code = jsQR(imageData.data, imageData.width, imageData.height);
    if (code) {
    qrResultElement.textContent = code.data;
    qrInputElement.value = code.data;
    verifyButton.click();
    console.log('Scanned content: ', code.data);
    messageElement.style.display = 'block';
    stopCamera();
    startCameraButton.style.display = 'block';
    videoElement.style.display = 'none';
    return;  // Stop scanning once a QR code is detected
}
}
    requestAnimationFrame(scanQRCode);
}

    function stopCamera() {
    if (currentStream) {
    currentStream.getTracks().forEach(track => track.stop());
}
}

    startCameraButton.addEventListener('click', () => {
    qrResultElement.textContent = '';
    messageElement.style.display = 'none';
    scanSection.style.display='block';
    qrInputElement.value='';
    startCamera();

});
    switchCameraButton.addEventListener('click', switchCamera);


