<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilgilendirme.</title>
    <style>
        .correction-title {
            font-weight: bold;
            color: orange;
        }

        h1 {
            font-size: 24px;
        }
    </style>
</head>
<div style="text-align: center; width:100%;">
    <img width="100%" height="60px" style="object-fit:contain"
        src="https://etikkurul.nisantasi.edu.tr/assets/images/logo-nisantasi.png" alt="Nisantasi Thumbnail">

</div>

<body style="font-family: 'Arial', sans-serif; width:100vw">

    <div style="margin: 20px;">
        {{ $slot }}
    </div>
    <div style="text-align: center; width:100%;">
        <img width="100%" height="80px"
            style="width: 6.5277in; height: 1.5833in; cursor: pointer; min-height: auto; min-width: auto;"
            src="https://etikkurul.nisantasi.edu.tr/assets/images/mail-thumnail.jpg" alt="Nisantasi Thumbnail">
    </div>
</body>

</html>
