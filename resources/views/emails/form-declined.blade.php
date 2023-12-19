<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Declined</title>
    <style>
        .correction-title {
            font-weight: bold;
            color: red;
        }

        h1 {
            font-size: 18px;
        }
    </style>
</head>

<body style="font-family: 'Arial', sans-serif;">
    <div style="text-align: center; margin: 20px;">
        <img src="https://etikkurul.nisantasi.edu.tr/assets/images/logo-nisantasi.png" alt="Nisantasi Logo" width="250">
    </div>
    <div style="text-align: center; margin: 20px;">
        <h1>Başvurunuz
            {{ Auth::user()->hasRole('sekreterlik') ? 'Sekreterlik ' : 'Etik Kurulu ' }} tarafından reddedildi
        </h1>
    </div>

    <div style="text-align: center; margin: 20px;">

        <p> <span class="correction-title">Red Gerekçesi:</span> {{ $decide_reason }}</p>
    </div>
    <div style="text-align: center; margin: 20px;">
        <img src="http://etikkurul.nisantasi.edu.tr/assets/images/mail-thumbnail.jpg" alt="Nisantasi Thumbnail">
    </div>
</body>

</html>
