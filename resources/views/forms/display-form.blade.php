<x-guest-layout>
    <style>
        table {
            width: 100%;
            max-width: 1024px;
            min-width: 300px;
            height: 100px;
            font-size: 16px;
        }

        td {
            word-wrap: break-word;
            /* or use overflow-wrap: break-word; */
            max-width: 200px;
            /* Set a specific max-width if needed */
        }

        @media (max-width: 500px) {
            .pdf-render {}
        }
    </style>
    <div class="pdf-render w-full  flex flex-col items-center  overflow-y-hidden  p-0 my-8 ">
        {{-- <button id="downloadPdf">Download PDF</button> --}}

        <style>
            td {
                padding: 0.5em 1em;
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
        <table class="">
            <tr class="text-center">
                <td class="w-2/12" colspan="1" style="border:solid #BFBFBF 1.0pt; ">
                    <img src="/assets/images/logo-nisantasi.png" class="w-full ">
                </td>
                <td colSpan="1" class="w-8/12">
                    <p><strong>T.C.</strong></p>
                    <p><strong>İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ</strong></p>
                    <p><strong>LİSANSÜSTÜ EĞİTİM ENSTİTÜSÜ</strong></p>
                    <p><strong>ETİK KURUL BAŞVURU FORMU</strong></p>
                    <p><em>Ethics Committee Application Form</em></p>
                </td>
                <td class="p-0" colspan="1" class="w-2/12">
                    <div style=' height:50%;text-align:center;border-bottom: 1pt solid rgb(191, 191, 191);  '>
                        <span style='font-size:11px;'>Tarih/Date</span>
                        <p style="font-size:11px;">
                            {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') }}
                        </p>
                    </div>
                    <div style='text-align:center; height:50%;'>
                        <span style='font-size:11px;'>Evrak No/Document Number</span>
                        <p style="font-size:11px;">
                            {{ $form->id }}
                        </p>
                    </div>

                </td>

            </tr>


        </table>
        <table>
            <tr class="bg-[#ac143c] text-white  w-full text-center">
                <td colspan="2" class="w-full">
                    <h2 class=" font-extrabold text-sm">1-Araştırmacı Bilgileri/Researcher Informations</h2>

                </td>

            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Araştırmacı Adı ve Soyadı:</p>
                    <p class="font-bold"><i>Name </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['name'] }}
                        {{ $form['lastname'] }}</p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Danışman/Yürütücü:</p>
                    <p class="font-bold"><i>Advisor </i></p>

                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['advisor'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Öğrenci No / TC No:</p>
                    <p class="font-bold"><i>Student ID Number </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['student_no'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Anabilim Dalı :</p>
                    <p class="font-bold"><i>Department </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['major'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Program :</p>
                    <p class="font-bold"><i>Department </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['department'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Telefon ve Mail :</p>
                    <p class="font-bold"><i>Phone and Mail </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p class="flex flex-col">
                        <span>
                            {{ $form['gsm'] }}
                        </span>
                        <span>
                            {{ $form['email'] }}

                        </span>
                    </p>
                </td>
            </tr>
        </table>

        {{-- BAŞVURU BİLGİLERİ TABLOSU --}}
        <table class="  ">
            <tr class="bg-[#ac143c] text-white  w-full text-center">
                <td colspan="2" class="w-full">
                    <h2 class=" font-extrabold text-sm">2-Başvuru Bilgileri/Application Informations</h2>

                </td>

            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Başvuru Dönemi:</p>
                    <p class="font-bold"><i>Term </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['application_semester'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Temel Alan Bilgisi:</p>
                    <p class="font-bold"><i>Basic Domain Knowledge</i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['temel_alan_bilgisi'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Başvuru Türü:</p>
                    <i class="font-bold">Program Type</i>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['application_type'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Çalışmanın Niteliği</p>
                    <p class="font-bold"><i>Nature of the Study </i></p>

                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['work_qualification'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Araştırma Türü :</p>
                    <p class="font-bold"><i>Research Type </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_type'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Kurum İzni :</p>
                    <p class="font-bold"><i>Department </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['institution_permission'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Araştırma Başlama ve Bitiş Tarihi :</p>
                    <p class="font-bold"><i>Research Start and End Date</i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p class="flex flex-col">
                        <span>
                            {{ $form['research_start_date'] }}
                        </span>
                        <span>
                            {{ $form['research_end_date'] }}

                        </span>
                    </p>
                </td>
            </tr>
        </table>

        {{-- ARAŞTIRMA BİLGİLERİ TABLOSU --}}
        <table>
            <tr class="bg-[#ac143c] text-white  w-full text-center">
                <td colspan="2" class="w-full">
                    <h2 class=" font-extrabold text-sm">3-Araştırma Bilgileri/Research Informations</h2>

                </td>

            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Araştırma Başlığı:</p>
                    <p class="font-bold"><i>Research Title </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_title'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Konu ve Amaç:</p>
                    <p class="font-bold"><i>Research Subject and Purpose</i></p>

                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_subject_purpose'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Özgün Değer:</p>
                    <p class="font-bold"><i>Unique value of Research</i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_unique_value'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Hipotezler/Araştırma Soruları</p>
                    <p class="font-bold"><i>Hypothesis</i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_hypothesis'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Yöntem :</p>
                    <p class="font-bold"><i>Research Method </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_method'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Evren ve Örneklem :</p>
                    <p class="font-bold"><i>Research Universe and Sample </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p> {{ $form['research_universe'] }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Ölçek ve Formlar :</p>
                    <p class="font-bold"><i>Scale and Forms </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p>
                        {{ $form['research_forms'] }}

                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Verilerin Toplanması ve Analizi:</p>
                    <p class="font-bold"><i>Data Collection and Analysis </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p>
                        {{ $form['research_data_collection'] }}

                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Sınırlar ve Kısıtlar:</p>
                    <p class="font-bold"><i>Research Restrictions </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p>
                        {{ $form['research_restrictions'] }}

                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Araştırma Yeri ve Tarihi:</p>
                    <p class="font-bold"><i>Research Place and Date </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p>
                        {{ $form['research_place_date'] }}

                    </p>
                </td>
            </tr>
            <tr>
                <td class="w-4/12">
                    <p class="font-bold">Faydalanılacak Kaynaklar/Literatür Taraması:</p>
                    <p class="font-bold"><i>Sources to Use/Literature Review </i></p>
                </td>
                <td class="w-8/12" colspan="3">
                    <p>
                        {{ $form['research_literature_review'] }}

                    </p>
                </td>
            </tr>
        </table>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </div>

</x-guest-layout>
