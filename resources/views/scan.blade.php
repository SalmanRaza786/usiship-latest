<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 450px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-outline-success mb-4" type="button" id="start-camera"><i class="ri-camera-line fs-24"></i> Scan Now</button>
            <div id="reader" style="display: none;"></div>
            <p id="qr-result" class="d-none">QR Code Result: <span id="qr-result-text"></span></p>
            <p id="message" class="d-none">QR Code has been scanned!</p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#start-camera').click(function () {
            $('#reader').show();
            $('#start-camera').hide();
            const html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start({ facingMode: { exact: "environment" } }, {
                fps: 10,
                qrbox: 250
            }, qrCodeMessage => {
                $('#qr-result-text').text(qrCodeMessage);
                $('#qr-result').removeClass('d-none');
                $('#message').removeClass('d-none');
                html5QrCode.stop().then(() => {
                    $('#reader').hide();
                    $('#start-camera').show();
                }).catch(err => console.error('Failed to stop QR Code reader:', err));
            }).catch(err => {
                console.error('Unable to start the QR code scanner:', err);
            });
        });
    });
</script>
</body>
</html>
