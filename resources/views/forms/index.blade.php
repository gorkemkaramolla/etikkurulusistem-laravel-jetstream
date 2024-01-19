<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
        integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"
        integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Etik Kurul Başvuru Formu</title>
    <style>
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


<body class="d-flex flex-column">





    @if (session('error'))
        <div>
            Error: {{ session('error') }}
        </div>
    @endif

    <div class="container">
        <a href="/dashboard" class="link-underline-primary">

            < Ana Sayfa </a>
                @if (isset($formData))
                    <div class="alert alert-warning">
                        <p class="m-3">
                            Başvurunuzu düzeltmeniz gerekmektedir. Gerekli değişiklikleri yaptıktan sonra tekrar
                            gönderiniz.
                        </p>
                        <p class="m-3">
                            You need to fix your application. Please fix the errors and submit again.
                        </p>
                        <p class=" m-3 underline text-danger ">
                            Etik Kurul Düzeltme Nedeni: {{ $formData['decide_reason'] }}

                        </p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('successMessage'))
                    <script>
                        Swal.fire({
                            title: "Success",
                            text: "{{ session('successMessage') }}",
                            icon: "success",
                            confirmButtonText: 'OK',
                        }).then(function() {
                            setTimeout(function() {
                                window.location.href = '/dashboard';
                            }, 3000);
                        });
                    </script>
                @endif {{-- <div
                        class="alert alert-success d-flex flex-column w-100 justify-content-center text-center items-center">
                        {!! session('successMessage') !!}
                        <a class="link-opacity-100" href="{{ url(session('linkPath')) }}">Başvuru aşamalarınızı takip
                            etmek için
                            lütfen bu
                            bağlantıya tıklayın veya aşağıdaki QR kodunu tarayın.</a>

                        <div class="w-100 d-flex justify-content-center" id="qrcode-container"></div>

                        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
                        <script type="text/javascript">
                            let linkPath = "{!! addslashes(session('linkPath')) !!}"; // Escape special characters
                            let linkText = "{{ url(session('linkPath')) }}";
                            let qrcodeContainer = document.getElementById("qrcode-container");
                            qrcodeContainer.innerHTML = "";
                            new QRCode(qrcodeContainer, {
                                text: linkText,
                                width: 256,
                                height: 256,
                                colorDark: "black",
                                colorLight: "white",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        </script>
                    </div> --}}
                <form enctype="multipart/form-data"
                    action="{{ url('store-form/' . (isset($formData) ? $formData->id : '')) }}" method="POST">
                    @csrf
                    <div class="row d-flex justify-content-center mb-1">
                        <img src="/assets/images/logo-nisantasi.png" style="width:180px;">
                    </div>
                    <h1 style="font-size: 1.2em" class=" text-center ">
                        T.C.
                        <br>
                        İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ<br>
                        <span style="font-size: 1em"> ETİK KURUL BAŞVURU FORMU</span><br>
                        <span>
                            ETHICS COMMITTEE APPLICATION FORM
                        </span>
                    </h1>


                    <x-forms.form-informations></x-forms.form-informations>
                    <div class="accordion" id="accordionPanelsStayOpenExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    ARAŞTIRMACI BİLGİLERİ
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show m-2"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <x-forms.researcher-informations :formData="$formData ?? null" />



                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    BAŞVURU BİLGİLERİ
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo"
                                class="accordion-collapse collapse {{ isset($formData) ? 'show' : '' }}"
                                aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <x-forms.application-informations
                                        :formData="$formData ?? null"></x-forms.application-informations>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    ARAŞTIRMA BİLGİLERİ
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree"
                                class="accordion-collapse collapse {{ isset($formData) ? 'show' : '' }}"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <x-forms.research-informations :formData="$formData ?? null"></x-forms.research-informations>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseFour">
                                    EK DOSYALAR
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour"
                                class="accordion-collapse collapse {{ isset($formData) ? 'show' : '' }}"
                                aria-labelledby="panelsStayOpen-headingFour">
                                <div class="accordion-body">
                                    <div
                                        class="d-flex flex-column gap-2 pt-5 justify-content-center align-items-center ">
                                        <div class="custom-file-input">

                                            <label id="path_gonullu_onam_form_label" for="onam_path"> Gönüllü
                                                Onam
                                                Formu</label>
                                            <input class="form-control" value="{{ old('onam_path') }}" type="file"
                                                name="onam_path" accept="application/pdf" id="onam_path" required>
                                        </div>
                                        <div class="custom-file-input">

                                            <label id="path_gonullu_onam_form_label" for="anket_path"> Anket
                                                Formu</label>
                                            <input class="form-control" type="file" name="anket_path"
                                                accept="application/pdf" value="{{ old('anket_path') }}"
                                                id="anket_path" required>
                                        </div>
                                        <div class="custom-file-input">

                                            <label id="path_gonullu_onam_form_label" for="kurum_izinleri_path">
                                                Kurum İzni
                                                (Varsa)</label>
                                            <input class="form-control" type="file" name="kurum_izinleri_path"
                                                accept="application/pdf " value="{{ old('kurum_izinleri_path') }}"
                                                id="kurum_izinleri_path">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- PDF DOCUMENTS -->


                    {{-- <div class="col-md-12 mt-3 pb-3 text-center">
                <a href="https://www.nisantasi.edu.tr/Uploads/LE_FR.17%20et%C4%B0k%20kurul%20ba%C5%9Evuru%20formu.docx">Gönüllü
                    Onam Formuna ulaşmak için tıklayınız</a>
            </div> --}}

                    <div class="container pb-4 text-center my-3 ">
                        <input type="submit" value="Başvuruyu Tamamla" class="btn btn-primary">
                    </div>

                </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(element) {
                return new bootstrap.Popover(element);
            });
        });
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>
