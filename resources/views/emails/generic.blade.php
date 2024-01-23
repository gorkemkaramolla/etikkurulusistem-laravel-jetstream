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
<div style="text-align: center; margin: 20px;">
    <img src="{{ asset('assets/images/logo-nisantasi.png') }}" alt="Nisantasi Logo" width="250">
</div>

<body style="font-family: 'Arial', sans-serif;">

    <div style="text-align: center; margin: 20px;">

        <p> <span class="correction-title"></span> {{ $emailMessage }}</p>
    </div>
    <div style="text-align: center; margin: 20px;">
        <img src="{{ asset('assets/images/mail-thumbnail.jpg') }}" alt="Nisantasi Thumbnail">
    </div>
</body>

</html>
