<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
</head>

<body>

    <h2>Form Submission</h2>

    <form action="{{ url('store-form') }}" method="post">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="tc_kimlik_no">TC Kimlik No:</label>
        <input type="text" id="tc_kimlik_no" name="tc_kimlik_no" required>

        <label for="calisma_basligi">Çalışma Başlığı:</label>
        <input type="text" id="calisma_basligi" name="calisma_basligi" required>

        <label for="calisma_programi">Çalışma Programı:</label>
        <input type="text" id="calisma_programi" name="calisma_programi" required>

        <button type="submit">Submit</button>
    </form>

</body>

</html>
