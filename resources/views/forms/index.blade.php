<!DOCTYPE html>
{{-- <html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <title>Form Submission</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="w-screen h-screen dark:bg-black  bg-red-200">

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

</html> --}}
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Sofia">


    <title>Etik Kurulu Formu</title>
</head>
@if (session('error'))
    <!-- Script to show a JavaScript alert on page load -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert("Error: {{ session('error') }}");
        });
    </script>
@endif

<body style="padding:20px" class="bg-light  " data-new-gr-c-s-check-loaded="14.1138.0" style=" border: none;">

    <div class="">
        <div class="col-md-6 m-auto" style="border-radius: 10px;">
            <div style="" class="  card shadow"
                style="box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 10px 1px rgb(0 0 0 / 20%);">
                <div class="card-header mt-3 text-center" style="background: #ffff ; border: none;">
                    <img src="assets/images/logo-nisantasi.png" width="140">
                    <h4 class="card-title w-100 mt-3 text-center opacity-75 ">İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ <br>Etik
                        Kurulu Formu</h4>
                </div>
                <div class="card-body ">
                    <form enctype="multipart/form-data" action="{{ url('store-form') }}" method="POST" class="mb-4">
                        @csrf

                        <div class="row d-flex justify-content-center">
                            <div class="row form_bilgi">
                                <div class="col-md-6 d-flex justify-content-end flex-column">
                                    <label for="name"style="text-transform: capitalize;">ad(Name) </label>
                                    <input name="name" id="name" class="form-control adsoyad" type="text"
                                        placeholder="Adınızı giriniz" oninput="validateInput(this)" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="lastname" style="text-transform: capitalize;">Soyad(Surname)</label>
                                    <input name="lastname" id="lastname" class="form-control adsoyad" type="text"
                                        placeholder="Soyadınızı giriniz" oninput="validateInput(this)" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="email" style="text-transform: capitalize;">Mail addresi </label>
                                    <input name="email" id="email" class="form-control adsoyad"
                                        type="text"placeholder="Mail addresinizi giriniz" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="ogrenci_no" style="text-transform: capitalize;">Öğrenci No(student
                                        No)</label>
                                    <input name="ogrenci_no" id="ogrenci_no" class="form-control adsoyad" type="text"
                                        placeholder="Öğrenci Numaranızı giriniz"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </div>
                            </div>
                            <!-- PDF DOCUMENTS -->
                            <div class="d-flex flex-column gap-2 justify-content-center align-items-center ">
                                <small class="form-text mt-4 text-muted text-transform: capitalize;">Lütfen Dosya Pdf
                                    Türünde Yükleniyiniz
                                    <span class="form-eng">
                                        (PDF Documents)
                                    </span>
                                </small>
                                <div class="custom-file-input">
                                    <label id="basvuru-form-title" for="basvuru-formu">Başvuru Formu</label>
                                    <input class="form-control" type="file" accept="application/pdf"
                                        id="basvuru-formu" required>
                                </div>
                                <div class="custom-file-input">
                                    <label id="path_gonullu_onam_form_label" for="path_gonullu_onam_form"> Gönüllü Onam
                                        Formu</label>
                                    <input class="form-control" type="file" name="path_gonullu_onam_form"
                                        accept="application/pdf" id="path_gonullu_onam_form" required>
                                </div>
                                <div class="custom-file-input">
                                    <label id="path_olcek_izinleri_form_label" for="path_olcek_izinleri_form"> Ölçek
                                        İzinleri
                                        Formu</label>
                                    <input class="form-control" type="file" accept="application/pdf"
                                        id="path_olcek_izinleri_form" name="path_olcek_izinleri_form" required>
                                </div>

                                <div class="custom-file-input">
                                    <label id="path_ anket_form_label" for="path_anket_form"> Anket Formu </label>
                                    <input class="form-control" type="file" accept="application/pdf"
                                        id="path_anket_form" name="path_anket_form" required>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="icheck-primary ">
                                    <div class=" d-flex justify-content-center mt-4 gap-2">
                                        <input style="width:1.3em; height:1.3em;" type="checkbox" id="remember"
                                            class="mt-1" style="display:block;" required>
                                        <label class="text-info" for="remember">
                                            Kişisel verilerin işlenmesi ve korunmasına yönelik aydınlatma metnini
                                            okudum, onaylıyorum.
                                            {{-- <span class="form-eng"> (I have read and understand the
                                                    clarification text for the processing and protection of personel
                                                    data.)
                                                </span> --}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 d-flex justify-content-center">
                                <input type="submit"
                                    class="btn btn-block btn-success btn-flat text-bold form_gonder_btn"
                                    style="text-transform: capitalize;" />

                            </div>
                            <div class="col-md-12 mt-3 text-center">
                                <a
                                    href="https://www.nisantasi.edu.tr/Uploads/LE_FR.17%20et%C4%B0k%20kurul%20ba%C5%9Evuru%20formu.docx">Başvuru
                                    formuna ulaşmak için tıklayınız
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        const input = document.querySelectorAll('.custom-file-input input');
        input.forEach((input) => {
            input.addEventListener('change', updateLabel);
        })

        function updateLabel() {
            var input = this; // 'this' refers to the file input element
            var label = document.getElementById(input.id + "-title");

            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                label.innerHTML = fileName;
            } else {
                label.innerHTML = 'Başvuru Formu';
            }
        }

        function validateInput(inputElement) {
            // Remove any numeric characters from the input
            inputElement.value = inputElement.value.replace(/[0-9]/g, '');
        }
    </script>
</body>

</html>
