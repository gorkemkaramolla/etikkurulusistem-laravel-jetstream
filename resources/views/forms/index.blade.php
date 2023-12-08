<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
        integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"
        integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="/assets/css/form.css">
    <title>Etik Kurulu Formu</title>

</head>


<body>



    @if (session('error'))
        <div>
            Error: {{ session('error') }}
        </div>
    @endif
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('store-form') }}" method="POST">
            @csrf
            <div class="row d-flex justify-content-center mb-1">
                <img src="assets/images/logo-nisantasi.png" style="width:180px;">
            </div>
            <h1 style="font-size: 1.2em" class=" text-center ">
                T.C.
                <br>
                İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ<br>
                <span style="font-size: 1em"> ETİK KURULU BAŞVURU FORMU</span><br>
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
                        <x-forms.researcher-informations></x-forms.researcher-informations>

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
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                        aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <x-forms.application-informations></x-forms.application-informations>

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
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                            <x-forms.research-informations></x-forms.research-informations>

                        </div>
                    </div>
                </div>
                {{-- <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                            aria-controls="panelsStayOpen-collapseFour">
                            ANKET BILGILERI
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                        aria-labelledby="panelsStayOpen-headingFour">
                        <div class="accordion-body">
                            <x-forms.questionaire></x-forms.questionaire>

                        </div>
                    </div>
                </div> --}}

            </div>

            <!-- PDF DOCUMENTS -->
            {{-- <div class="d-flex flex-column gap-2 pt-5 justify-content-center align-items-center ">
                <div class="custom-file-input">
                    <small class="form-text mt-4 text-muted text-transform: capitalize;">Lütfen Dosya Pdf
                        Türünde Yükleniyiniz
                        <span class="form-eng">
                            (PDF Documents)
                        </span>
                    </small>
                    <label id="path_gonullu_onam_form_label" for="path_gonullu_onam_form"> Gönüllü Onam Formu</label>
                    <input class="form-control" type="file" name="path_gonullu_onam_form" accept="application/pdf"
                        id="path_gonullu_onam_form" required>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="icheck-primary ">
                    <div class=" d-flex justify-content-center mt-4 gap-2">
                        <input style="width:1.3em; height:1.3em;" type="checkbox" id="remember" class="mt-1"
                            style="display:block;" required>
                        <label class="text-info" for="remember"> Kişisel verilerin işlenmesi ve korunmasına yönelik
                            aydınlatma metnini okudum, onaylıyorum.
                            <span class="form-eng"> (I have read and understand the
                                clarification text for the processing and protection of personel
                                data.)
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3 pb-3 text-center">
                <a href="https://www.nisantasi.edu.tr/Uploads/LE_FR.17%20et%C4%B0k%20kurul%20ba%C5%9Evuru%20formu.docx">Gönüllü
                    Onam Formuna ulaşmak için tıklayınız</a>
            </div>
          --}}
            <div class="container pb-4 text-center">
                <input type="submit" class="btn btn-primary" style="width: 200px;">
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
