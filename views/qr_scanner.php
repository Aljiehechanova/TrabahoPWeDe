<?php
// upload_qr.php
// No backend processing is needed here yet, it's all frontend
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Upload Bacolod PWD QR Code</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <script type="module">
    import QrScanner from "https://unpkg.com/qr-scanner@1.4.2/qr-scanner.min.js";

    window.addEventListener('DOMContentLoaded', () => {
      const fileInput = document.getElementById('qr-file');
      const result = document.getElementById('result');
      const form = document.getElementById('redirectForm');

      fileInput.addEventListener('change', event => {
        const file = event.target.files[0];
        if (!file) return;

        QrScanner.scanImage(file, { returnDetailedScanResult: true })
          .then(scanResult => {
            const text = scanResult.data;

            try {
              const url = new URL(text);

              // Extract the "content" parameter from QR URL
              const qrId = url.searchParams.get("content");

              if (qrId) {
                document.getElementById("qr_id").value = qrId;

                result.innerText = "QR code valid. Proceeding to registration...";

                setTimeout(() => {
                  form.submit();
                }, 1500);
              } else {
                result.innerText = "QR code is missing the 'content' parameter.";
              }

            } catch (e) {
              result.innerText = "Invalid QR code format (expected Bacolod PWD URL).";
            }
          })
          .catch(e => {
            result.innerText = "Failed to scan QR code: " + e;
          });
      });
    });
  </script>

</head>

<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h3 class="mb-4">Upload Bacolod PWD QR Code</h3>

        <input type="file" accept="image/*" id="qr-file" class="form-control mb-3">
        <div id="result" class="text-danger fw-bold mt-3"></div>

        <form id="redirectForm" action="registration_step1.php" method="POST">
          <input type="hidden" name="qr_id" id="qr_id">
        </form>

        <!-- Go Back Button -->
        <a href="RC.php" class="btn btn-secondary mt-4">Go Back</a>

      </div>
    </div>
  </div>

</body>
</html>
