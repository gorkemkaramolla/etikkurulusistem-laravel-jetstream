<x-guest-layout>
    <style>
        table {
            width: 100%;
            height: 100px;
            font-size: 16px;
        }

        .pdf-render {
            padding: 1em 4em;
        }

        * {
            box-sizing: border-box;
        }
    </style>
    <div class="pdf-render w-full max-h-[200dvh] overflow-y-hidden overflow-x-hidden p-0 m-0 ">
        {{-- <button id="downloadPdf">Download PDF</button> --}}

        @foreach ($forms as $form)
            <style>
                td {
                    border-top: 1pt solid rgb(191, 191, 191);
                    border-right: 1pt solid rgb(191, 191, 191);
                    border-bottom: 1pt solid rgb(191, 191, 191);
                    border-left: 1pt solid rgb(191, 191, 191);
                    border-image: initial;
                    max-height: 100px;
                }

                p {

                    line-height: normal;

                }
            </style>
            <div class="first">
                <div class=" w-full ">
                    <table>
                        <tr class="text-center">
                            <td class="w-2/12" colspan="1" style="border:solid #BFBFBF 1.0pt; ">
                                <img src="/assets/images/logo-nisantasi.png" class="w-full ">
                            </td>
                            <td colSpan="1" class="w-8/12">
                                <p style=''>
                                    <strong>
                                        <span style='font-size:12px;color:black;'>T.C.</span>
                                    </strong>
                                </p>
                                <p style=''>
                                    <strong>
                                        <span style='font-size:12px;color:black;'>İSTANBUL
                                            NİŞANTAŞI
                                            &Uuml;NİVERSİTESİ</span>
                                    </strong>
                                </p>
                                <p style=''>
                                    <strong>
                                        <span style='font-size:12px;color:black;'>LİSANS&Uuml;ST&Uuml;
                                            EĞİTİM
                                            ENSTİT&Uuml;S&Uuml;</span>
                                    </strong>
                                </p>
                                <p style=''>
                                    <strong>
                                        <span style='color:black;'>&nbsp;ETİK KURUL BAŞVURU
                                            FORMU</span>
                                    </strong>
                                </p>
                                <p style=''>
                                    <em>
                                        <span style='font-size:12px;color:black;'>Ethics
                                            Committee
                                            Applicatıon Form</span>
                                    </em>
                                </p>
                            </td>
                            <td class="p-0" colspan="1" class="w-2/12">
                                <div
                                    style=' height:50%;text-align:center;border-bottom: 1pt solid rgb(191, 191, 191);  '>
                                    <span style='font-size:11px;'>Tarih/Date</span>
                                    <p style="font-size:11px;">
                                        {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div style='text-align:center; height:50%;'>
                                    <span style='font-size:11px;'>Evrak No</span>
                                    <p style="font-size:11px;">
                                        {{ $form['document_number'] }}
                                    </p>
                                </div>

                            </td>

                        </tr>


                    </table>
                    <table>
                        <div class="bg-gray-200  w-full text-center">
                            <h1 class=" font-extrabold">1-Araştırmacı Bilgileri</h1>

                        </div>
                        <tr>
                            <td class="w-4/12">
                                <p>Araştırmacı Adı ve Soyadı:</p>
                                <p><i>Name </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['researcher_informations']['name'] }}
                                    {{ $form['researcher_informations']['lastname'] }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Danışman/Yürütücü:</p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['researcher_informations']['advisor'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Öğrenci No / TC No:</p>
                                <p><i>Student ID Number </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['researcher_informations']['student_no'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Anabilim Dalı :</p>
                                <p><i>Department </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['researcher_informations']['major'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Program :</p>
                                <p><i>Department </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['researcher_informations']['department'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Telefon ve Mail :</p>
                                <p><i>Phone and Mail </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p class="flex flex-col">
                                    <span>
                                        {{ $form['researcher_informations']['gsm'] }}
                                    </span>
                                    <span>
                                        {{ $form['researcher_informations']['email'] }}

                                    </span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class=" w-full ">

                    {{-- BAŞVURU BİLGİLERİ TABLOSU --}}
                    <table class="  ">
                        <div class="bg-gray-200  w-full text-center">
                            <h1 class=" font-extrabold">2-Başvuru Bilgileri</h1>

                        </div>
                        <tr>
                            <td class="w-4/12">
                                <p>Başvuru Dönemi:</p>
                                <p><i>Term </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['application_semester'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Temel Alan Bilgisi:</p>
                                <p><i>Basic Domain Knowledge</i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['temel_alan_bilgisi'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Başvuru Türü:</p>
                                <i>Program Type</i>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['application_type'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Çalışmanın Niteliği</p>
                                <p><i>Nature of the Study </i></p>

                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['work_qualification'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Araştırma Türü :</p>
                                <p><i>Research Type </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['research_type'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Kurum İzni :</p>
                                <p><i>Department </i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p> {{ $form['application_informations']['institution_permission'] }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-4/12">
                                <p>Araştırma Başlama ve Bitiş Tarihi :</p>
                                <p><i>Research Start and End Date</i></p>
                            </td>
                            <td class="w-8/12" colspan="3">
                                <p class="flex flex-col">
                                    <span>
                                        {{ $form['application_informations']['research_start_date'] }}
                                    </span>
                                    <span>
                                        {{ $form['application_informations']['research_end_date'] }}

                                    </span>
                                </p>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class=" w-full break-before ">
                {{-- ARAŞTIRMA BİLGİLERİ TABLOSU --}}
                <table>
                    <div class="bg-gray-200  w-full text-center">
                        <h1 class=" font-extrabold">3-Araştırma Bilgileri</h1>

                    </div>
                    <tr>
                        <td class="w-4/12">
                            <p>Araştırma Başlığı:</p>
                            <p><i>Research Title </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_title'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Konu ve Amaç:</p>
                            <p><i>Research Subject and Purpose</i></p>

                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_subject_purpose'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Özgün Değer:</p>
                            <i>Unique value of Research</i>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_unique_value'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Hipotezler/Araştırma Soruları</p>
                            <p><i>Hypothesis</i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_hypothesis'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Yöntem :</p>
                            <p><i>Research Method </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_method'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Evren ve Örneklem :</p>
                            <p><i>Research Universe and Sample </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p> {{ $form['research_informations']['research_universe'] }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Ölçek ve Formlar :</p>
                            <p><i>Scale and Forms </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p>
                                {{ $form['research_informations']['research_forms'] }}

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Verilerin Toplanması ve Analizi:</p>
                            <p><i>Data Collection and Analysis </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p>
                                {{ $form['research_informations']['research_data_collection'] }}

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Sınırlar ve Kısıtlar:</p>
                            <p><i>Research Restrictions </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p>
                                {{ $form['research_informations']['research_restrictions'] }}

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Araştırma Yeri ve Tarihi:</p>
                            <p><i>Research Place and Date </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p>
                                {{ $form['research_informations']['research_place_date'] }}

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-4/12">
                            <p>Faydalanılacak Kaynaklar/Literatür Taraması:</p>
                            <p><i>Sources to Use/Literature Review </i></p>
                        </td>
                        <td class="w-8/12" colspan="3">
                            <p>
                                {{ $form['research_informations']['research_literature_review'] }}

                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach


        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>



        {{-- <script>
            document.getElementById('downloadPdf').addEventListener('click', function() {
                // Target the element that you want to convert to PDF
                const element = document.querySelector(".pdf-render");

                // Hide the button temporarily
                const downloadButton = document.getElementById('downloadPdf');
                downloadButton.style.display = 'none';

                // Use html2pdf to generate the PDF
                html2pdf(element, {
                        filename: 'document.pdf',
                        html2canvas: {
                            scale: 2, // Adjust scale as needed
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'portrait', // or 'landscape'
                        },

                        pagebreak: {
                            before: '.break-before',
                            after: '.break-after',
                        }
                    })
                    .from(element)
                    .outputPdf()
                    .then((pdf) => {
                        // Show the button again
                        downloadButton.style.display = 'block';

                        // Download the PDF
                        const blob = new Blob([pdf], {
                            type: 'application/pdf'
                        });
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'document.pdf';
                        link.click();
                    });
            });
        </script> --}}






    </div>

</x-guest-layout>
