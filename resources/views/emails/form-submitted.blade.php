<!-- resources/views/emails/form-submitted.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etik kurulu başvurunuz başarıyla gönderilmiştir.</title>
</head>

<body style="font-family: 'Arial', sans-serif;">

    <div style="text-align: center; margin: 20px;">
        <img src="https://etikkurul.nisantasi.edu.tr/assets/images/logo-nisantasi.png" alt="Nisantasi Logo" width="250">
    </div>

    <div style="text-align: center; margin: 20px;">
        <p style="font-size: 16px; line-height: 1.5;">Etik kurulu başvurunuz bizlere ulaşmıştır. Başvurunuz
            sonuçlandığında size
            mail olarak iletilecektir.</p>
    </div>

    <div style="margin: 20px;">
        <h2 style="text-align: center;">Başvurunuzun Detayları</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>

            </thead>
            <tbody>
                @foreach ($formFields as $field => $value)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #dddddd; text-align: left;">
                            {{ $fieldNameMappings[$field] ?? $field }}</td>
                        <td style="padding: 10px; border: 1px solid #dddddd; text-align: left;">{{ $value }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div style="text-align: center; margin: 20px;">
        <img src="http://etikkurul.nisantasi.edu.tr/assets/images/mail-thumbnail.jpg" alt="Nisantasi Thumbnail">
    </div>
</body>

</html>
