<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
</head>
<body>

    <h2>Form Submission</h2>

    <form action="{{ route('form.store') }}" method="post">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="tc_kimlik_no">TC Kimlik No:</label>
        <input type="text" id="tc_kimlik_no" name="tc_kimlik_no" required>

        <label for="calisma_basligi">Çalışma Başlığı:</label>
        <input type="text" id="calisma_basligi" name="calisma_basligi" required>

        <label for="calisma_programi">Çalışma Programı:</label>
        <input type="text" id="calisma_programi" name="calisma_programi" required>

        <label for="path_gonullu_onam_form">Gönüllü Onam Formu Yolu:</label>
        <input type="text" id="path_gonullu_onam_form" name="path_gonullu_onam_form" required>

        <label for="path_anket_form">Anket Formu Yolu:</label>
        <input type="text" id="path_anket_form" name="path_anket_form" required>

        <label for="path_olcek_izinleri_form">Ölçek İzinleri Formu Yolu:</label>
        <input type="text" id="path_olcek_izinleri_form" name="path_olcek_izinleri_form" required>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
