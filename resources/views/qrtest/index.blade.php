<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled QR Code</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {}

        h1 {
            color: #333;
        }

        #qrcode-container {
            display: block;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .qrcode {
            width: 256px;
            height: 256px;
            background-color: white;
        }
    </style>
</head>

<body>

    <div class="form">

        <div id="qrcode-container">
            <div id="qrcode-2" class="qrcode"></div>
        </div>

        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        <script type="text/javascript">
            let qrcodeContainer2 = document.getElementById("qrcode-2");
            qrcodeContainer2.innerHTML = "";
            new QRCode(qrcodeContainer2, {
                text: "etikkurul.nisantasi.edu.tr",
                width: 256,
                height: 256,
                colorDark: "black",
                colorLight: "white",
                correctLevel: QRCode.CorrectLevel.H
            });
        </script>
    </div>

</body>

</html>
