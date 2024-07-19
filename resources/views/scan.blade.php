<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
<div id="my-qr-reader" style="width:500px"></div>
<button id="start-scanner">Start QR Scanner</button>
<input type="text" id="qr-input" readonly>
<button id="verify-button" style="display:none;">Verify</button>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        function domReady(fn) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                setTimeout(fn, 1000);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        domReady(function () {
            const qrInputElement = document.getElementById('qr-input');
            const startScannerButton = document.getElementById('start-scanner');
            const verifyButton = document.getElementById('verify-button');
            let htmlscanner;

            function onScanSuccess(decodeText, decodeResult) {
                qrInputElement.value = decodeText;
                alert("Your QR is: " + decodeText, decodeResult);
                verifyButton.click();
                if (htmlscanner) {
                    htmlscanner.clear(); // Stop the camera
                }
            }

            startScannerButton.addEventListener('click', function () {
                startScannerButton.style.display = 'none';
                htmlscanner = new Html5QrcodeScanner(
                    "my-qr-reader",
                    { fps: 10, qrbox: 250 }
                );
                htmlscanner.render(onScanSuccess);
            });
        });
    });
</script>
</body>
</html>
