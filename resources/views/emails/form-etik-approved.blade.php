<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvurunuz Sekreterlik Tarafından Onaylanmıştır.</title>
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

<body style="font-family: 'Arial', sans-serif;">
    <div style="text-align: center; margin: 20px;">
        <img src="https://etikkurul.nisantasi.edu.tr/assets/images/logo-nisantasi.png" alt="Nisantasi Logo" width="180">
    </div>
    <div style="text-align: center; margin: 20px;">
        <h1>Başvurunuz Sekreterlik tarafından onaylanarak Etik Kurul karar aşamasına geçmiştir.
        </h1>
    </div>
    <div style="text-align: center; margin: 20px;">

        <p> <span class="correction-title">Düzeltme Gerekçesi:</span> {{ $decide_reason }}</p>
    </div>
    <div style="text-align: center; margin: 20px;">
        <img src="http://etikkurul.nisantasi.edu.tr/assets/images/mail-thumbnail.jpg" alt="Nisantasi Thumbnail">
    </div>
</body>

</html>
