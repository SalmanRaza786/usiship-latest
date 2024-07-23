let currentStream;
const videoElement = document.getElementById('preview');
const canvasElement = document.getElementById('canvas');
const canvasContext = canvasElement.getContext('2d');
const qrResultElement = document.getElementById('qr-result-text');
const messageElement = document.getElementById('message');
const startCameraButton = document.getElementById('start-camera');
const scanSection = document.getElementById('scan-section');
const qrInputElement = document.getElementById('warehouseId');
const verifyButton = document.getElementById('verifyButton');

async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: { exact: "environment" },
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });
        currentStream = stream;
        videoElement.srcObject = stream;
        videoElement.play();
        scanQRCode();
        videoElement.style.display = 'block';
        startCameraButton.style.display = 'none';
    } catch (error) {
        console.error('Error accessing the back camera: ', error);
        alert('Error accessing the back camera: ' + error.message);
    }
}

function scanQRCode() {
    if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
        canvasElement.width = videoElement.videoWidth;
        canvasElement.height = videoElement.videoHeight;
        canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
        const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
        console.log('Scanning for QR code...');
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
        } else {
            alert('No QR code detected');
            console.log('No QR code detected.');
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
    scanSection.style.display = 'block';
    qrInputElement.value = '';
    startCamera();
});

// Start the camera immediately for testing purposes
document.addEventListener('DOMContentLoaded', () => {
    startCamera();
});
