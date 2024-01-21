@props(['form'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@if (Auth::user()->role == 'admin')
@endif

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
        td,
        th {
            padding: 0.5em 1em;
            border-top: 1pt solid rgb(191, 191, 191);
            border-right: 1pt solid rgb(191, 191, 191);
            border-bottom: 1pt solid rgb(191, 191, 191);
            border-left: 1pt solid rgb(191, 191, 191);
            border-image: initial;
            max-height: 100px;
            text-align: left;
        }

        p {
            line-height: normal;
        }
    </style>
    <table class="">
        <tr class="text-center">
            <th class="w-2/12" colspan="1" style="border:solid #BFBFBF 1.0pt; ">
                <img src="/assets/images/logo-nisantasi.png" class="w-full ">
            </th>
            <th colSpan="1" class="w-8/12 text-center">
                <p><strong>T.C.</strong></p>
                <p><strong>İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ</strong></p>
                <p><strong>LİSANSÜSTÜ EĞİTİM ENSTİTÜSÜ</strong></p>
                <p><strong>ETİK KURUL BAŞVURU FORMU</strong></p>
                <p><em>Ethics Committee Application Form</em></p>
            </th>
            <th class="p-0" colspan="1" class="w-2/12">
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

            </th>

        </tr>


    </table>
    <table>
        <tr class="bg-[#ac143c] text-white  w-full text-center">
            <th colspan="2" class="w-full">
                <h2 class="font-extrabold text-sm">1-Araştırmacı Bilgileri/Researcher Informations</h2>
            </th>
        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Araştırmacı Adı:</p>
                <p class="font-bold"><i>Name </i></p>
            </th>
            <td data-column-name="name" class="w-8/12" colspan="3">
                <p> {{ $form['name'] }} </p>
            </td>

        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Araştırmacı Soyadı:</p>
                <p class="font-bold"><i>Lastname</i></p>
            </th>
            <td data-column-name="lastname" class="w-8/12" colspan="3">
                <p> {{ $form['lastname'] }} </p>
            </td>

        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Öğrenci No / TC No:</p>
                <p class="font-bold"><i>Student ID Number </i></p>
            </th>
            <td data-column-name="student_no" class="w-8/12" colspan="3">
                <p> {{ $form['student_no'] }}</p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Telefon:</p>
                <p class="font-bold"><i>Phone Number </i></p>
            </th>
            <td data-column-name="gsm" class="w-8/12" colspan="3">
                <p class="flex flex-col">
                    <span>{{ $form['gsm'] }}</span>
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">E-Posta:</p>
                <p class="font-bold"><i>Email </i></p>
            </th>
            <td data-column-name="email" class="w-8/12" colspan="3">
                <p class="flex flex-col">
                    <span>{{ $form['email'] }}</span>
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Danışman/Yürütücü:</p>
                <p class="font-bold"><i>Advisor </i></p>
            </th>
            <td data-column-name="advisor" class="w-8/12" colspan="3">
                <p> {{ $form['advisor'] }}</p>
            </td>
        </tr>

        <tr>
            <th class="w-4/12">
                <p class="font-bold">Anabilim Dalı:</p>
                <p class="font-bold"><i>Department </i></p>
            </th>
            <td data-column-name="ana_bilim_dali" class="w-8/12" colspan="3">
                <p> {{ $form['ana_bilim_dali'] }}</p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12">
                <p class="font-bold">Program:</p>
                <p class="font-bold"><i>Department </i></p>
            </th>
            <td data-column-name="program" class="w-8/12" colspan="3">
                <p> {{ $form['program'] }}</p>
            </td>
        </tr>

    </table>

    {{-- BAŞVURU BİLGİLERİ TABLOSU --}}
    <table class=" ">
        <tr class="bg-[#ac143c] text-white  w-full text-center">
            <th colspan="2" class="w-full">
                <h2 class="font-extrabold text-sm">2-Başvuru Bilgileri/Application Informations</h2>
            </th>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="application_semester">
                <p class="font-bold">Başvuru Dönemi:</p>
                <p class="font-bold"><i>Term </i></p>
            </th>
            <td data-column-name="application_semester" class="w-8/12" colspan="3">
                <p> {{ $form['application_semester'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="temel_alan_bilgisi">
                <p class="font-bold">Temel Alan Bilgisi:</p>
                <p class="font-bold"><i>Basic Domain Knowledge</i></p>
            </th>
            <td data-column-name="temel_alan_bilgisi" class="w-8/12" colspan="3">
                <p> {{ $form['temel_alan_bilgisi'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="application_type">
                <p class="font-bold">Başvuru Türü:</p>
                <i class="font-bold">Program Type</i>
            </th>
            <td data-column-name="application_type" class="w-8/12" colspan="3">
                <p> {{ $form['application_type'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="work_qualification">
                <p class="font-bold">Çalışmanın Niteliği:</p>
                <p class="font-bold"><i>Nature of the Study </i></p>
            </th>
            <td data-column-name="work_qualification" class="w-8/12" colspan="3">
                <p> {{ $form['work_qualification'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_type">
                <p class="font-bold">Araştırma Türü:</p>
                <p class="font-bold"><i>Research Type </i></p>
            </th>
            <td data-column-name="research_type" class="w-8/12" colspan="3">
                <p> {{ $form['research_type'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="institution_permission">
                <p class="font-bold">Kurum İzni:</p>
                <p class="font-bold"><i>Department </i></p>
            </th>
            <td data-column-name="institution_permission" class="w-8/12" colspan="3">
                <p> {{ $form['institution_permission'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_start_date">
                <p class="font-bold">Araştırma Başlama Tarihi:</p>
                <p class="font-bold"><i>Research Start Date </i></p>
            </th>
            <td data-column-name="research_start_date" class="w-8/12" colspan="3">
                <p class="flex flex-col">
                    <span>
                        {{ $form['research_start_date'] }}
                    </span>

                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_start_date">
                <p class="font-bold">Araştırma Bitiş Tarihi:</p>
                <p class="font-bold"><i>Research End Date </i></p>
            </th>
            <td data-column-name="research_end_date" class="w-8/12" colspan="3">
                <p class="flex flex-col">
                    <span>
                        {{ $form['research_end_date'] }}
                    </span>

                </p>
            </td>
        </tr>
    </table>


    {{-- ARAŞTIRMA BİLGİLERİ TABLOSU --}}
    <table>
        <tr class="bg-[#ac143c] text-white w-full text-center">
            <th colspan="4" class="w-full">
                <h2 class="font-extrabold text-sm">3-Araştırma Bilgileri/Research Informations</h2>
            </th>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_title">
                <p class="font-bold">Araştırma Başlığı:</p>
                <p class="font-bold"><i>Research Title </i></p>
            </th>
            <td data-column-name="research_title" class="w-8/12" colspan="3">
                <p> {{ $form['research_title'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_subject_purpose">
                <p class="font-bold">Konu ve Amaç:</p>
                <p class="font-bold"><i>Research Subject and Purpose</i></p>
            </th>
            <td data-column-name="research_subject_purpose" class="w-8/12" colspan="3">
                <p> {{ $form['research_subject_purpose'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_unique_value">
                <p class="font-bold">Özgün Değer:</p>
                <p class="font-bold"><i>Unique value of Research</i></p>
            </th>
            <td data-column-name="research_unique_value" class="w-8/12" colspan="3">
                <p> {{ $form['research_unique_value'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_hypothesis">
                <p class="font-bold">Hipotezler/Araştırma Soruları</p>
                <p class="font-bold"><i>Hypothesis</i></p>
            </th>
            <td data-column-name="research_hypothesis" class="w-8/12" colspan="3">
                <p> {{ $form['research_hypothesis'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_method">
                <p class="font-bold">Yöntem :</p>
                <p class="font-bold"><i>Research Method </i></p>
            </th>
            <td data-column-name="research_method" class="w-8/12" colspan="3">
                <p> {{ $form['research_method'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_universe">
                <p class="font-bold">Evren ve Örneklem :</p>
                <p class="font-bold"><i>Research Universe and Sample </i></p>
            </th>
            <td data-column-name="research_universe" class="w-8/12" colspan="3">
                <p> {{ $form['research_universe'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_forms">
                <p class="font-bold">Ölçek ve Formlar :</p>
                <p class="font-bold"><i>Scale and Forms </i></p>
            </th>
            <td data-column-name="research_forms" class="w-8/12" colspan="3">
                <p> {{ $form['research_forms'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_data_collection">
                <p class="font-bold">Verilerin Toplanması ve Analizi:</p>
                <p class="font-bold"><i>Data Collection and Analysis </i></p>
            </th>
            <td data-column-name="research_data_collection" class="w-8/12" colspan="3">
                <p> {{ $form['research_data_collection'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_restrictions">
                <p class="font-bold">Sınırlar ve Kısıtlar:</p>
                <p class="font-bold"><i>Research Restrictions </i></p>
            </th>
            <td data-column-name="research_restrictions" class="w-8/12" colspan="3">
                <p> {{ $form['research_restrictions'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_place_date">
                <p class="font-bold">Araştırma Yeri ve Tarihi:</p>
                <p class="font-bold"><i>Research Place and Date </i></p>
            </th>
            <td data-column-name="research_place_date" class="w-8/12" colspan="3">
                <p> {{ $form['research_place_date'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="research_literature_review">
                <p class="font-bold">Faydalanılacak Kaynaklar/Literatür Taraması:</p>
                <p class="font-bold"><i>Sources to Use/Literature Review </i></p>
            </th>
            <td data-column-name="research_literature_review" class="w-8/12" colspan="3">
                <p> {{ $form['research_literature_review'] }}
                </p>
            </td>
        </tr>
        <tr>
            <th class="w-4/12" data-column-name="conclusion_date">
                <p class="font-bold">Sonuçlanma Tarihi</p>
                <p class="font-bold"><i>Conclusion Date</i></p>
            </th>
            <td data-column-name="conclusion_date" class="w-8/12" colspan="3">
                <p> {{ $form['conclusion_date'] }}
                </p>
            </td>
        </tr>
        <tr class="w-full">
            <th class="w-4/12">
                <p>Ek dosyalar</p>
                <i>Additional Files
                </i>
            </th>
            <td class="w-4/12 text-center" colspan="1">
                <a target="_blank"
                    class="inline-flex justify-between items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                    href="{{ url('/show-pdf/' . $form->onam_path) }}">
                    Gönüllü Onam Formu
                    <x-svg.download />

                </a>

            </td>
            <td class="w-4/12 text-center" colspan="1">
                <a target="_blank"
                    class="inline-flex justify-between items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                    href="{{ url('/show-pdf/' . $form->anket_path) }}">
                    Anket Formu
                    <x-svg.download />

                </a>
            </td>
            <td class="w-4/12 text-center" colspan="1">
                @if ($form->kurum_izinleri_path)
                    <a target="_download"
                        class="flex justify-between items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                        href="{{ url('/show-pdf/' . $form->kurum_izinleri_path) }}">

                        Kurum İzinleri
                        <x-svg.download />

                    </a>
                @endif
            </td>
        </tr>
        @if (Auth::user()->role === 'sekreterlik' || Auth::user()->role === 'etik_kurul')
            <tr>
                <td colspan="2" class="text-center">
                    @if (auth()->user()->hasRole('sekreterlik') &&
                            $form &&
                            $form->stage === 'sekreterlik')
                        <x-approve-modal :formid="$form->id"></x-approve-modal>
                    @elseif(auth()->user()->hasRole('etik_kurul'))
                        @php
                            // Check if there is an ethics committee approval for the specific form and user
                            $etikKurulOnayi = $form->etik_kurul_onayi
                                ->where('form_id', $form->id) // Check form_id
                                ->where('user_id', auth()->user()->id) // Check user_id
                                ->first();
                        @endphp

                        @if ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'onaylandi')
                            <span class="text-green-600">Etik kurulu onay oyu verdiniz.</span>
                        @elseif ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'reddedildi')
                            <span class="text-red-600">Etik kurulu red oyu verdiniz.</span>
                        @elseif ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'duzeltme')
                            <span class="text-yellow-500">Etik kurulu düzeltme oyu verdiniz.</span>
                        @else
                            <x-approve-modal :formid="$form->id"></x-approve-modal>
                        @endif
                    @elseif (request()->segment(2) === 'duzeltme')
                        <p class="text-orange-500">Düzeltilmesi Bekleniyor</p>
                    @elseif (request()->segment(2) === 'reddedildi')
                        <p class="text-red-500">Reddedildi</p>
                    @endif
                </td>
            </tr>

        @endif
    </table>

    @if (Auth::user()->role === 'admin')
        <div class="flex gap-3 my-4">
            <x-tw-button id="editButton" onclick="makeEditable()">Düzenle</x-tw-button>
            <x-tw-button id="saveButton" onclick="saveChanges()" style="display: none;">Kaydet</x-tw-button>
        </div>
    @endif

    <script>
        function makeEditable() {
            @if (Auth::user()->role == 'admin')
                var cells = $('td:not(.not-editable)');
                cells.attr('contenteditable', true).css('border', '2px solid #000'); // Change border style here
                // Add "contenteditable" attribute to make cells editable
                cells.attr('contenteditable', true).css('border', '1pt solid rgb(191, 191, 191)');

                // Hide the "Edit" button and show the "Save" button
                $('#editButton').hide();
                $('#saveButton').show();

                // Add a keyup event listener to the cells to mark them as edited when they're changed
                cells.on('input', function() {
                    $(this).attr('data-edited', 'true');
                });
            @endif
        }

        function saveChanges() {
            var cells = $('td[contenteditable="true"]');
            var changes = {};

            // Collect the updated data from editable cells
            cells.each(function() {
                var columnName = $(this).data('column-name');
                var cellValue = $(this).text();

                // Only add the change to the changes object if the cell has been edited
                if ($(this).attr('data-edited') === 'true') {
                    changes[columnName] = cellValue.trim();
                }
            });

            // Show an alert with the names of the edited columns
            Swal.fire({
                title: "Emin misiniz?",
                text: 'Aşağıdaki sütunları düzenlemek istediğinizden emin misiniz: ' + Object.keys(changes).join(
                    ', '),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Evet, düzenle!',
                cancelButtonText: 'Hayır, iptal!',
                dangerMode: true,
            }).then((willEdit) => {
                if (!willEdit) {
                    return;
                }

                // AJAX request
                $.ajax({
                    url: '/fix-form/' + {{ $form['id'] }},
                    method: 'POST',
                    data: JSON.stringify(changes),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Success",
                                text: response.success,
                                icon: "success",
                                confirmButtonText: 'OK',
                            });
                        } else if (response.error) {
                            Swal.fire({
                                title: "Error",
                                text: response.error,
                                icon: "error",
                                confirmButtonText: 'OK',
                            });
                        } else {
                            console.log(response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                            Swal.fire({
                                title: "Hata",
                                text: 'Bir Hata Oluştu: ' + jqXHR.responseJSON.error,
                                icon: "error",
                                confirmButtonText: 'Tamam',
                            });
                        } else {
                            Swal.fire({
                                title: "Hata",
                                text: 'Bir Hata Oluştu: ' + textStatus + ' - ' + errorThrown,
                                icon: "error",
                                confirmButtonText: 'Tamam',
                            });
                        }
                        location.reload(); // Refresh the page
                    },
                });

                cells.attr('contenteditable', false).css('border', '1px solid #ccc');

                // Remove the "Save" button
                $('#saveButton').hide();
                $('#editButton').show();
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</div>
<style>
    @keyframes breathe {

        0%,
        100% {
            background-color: #fff;
            /* initial and final background color */
        }

        50% {
            background-color: #f5f1f1;
            /* background color in the middle of the animation */
        }
    }

    [contenteditable="true"] {
        animation: breathe 3s ease-in-out infinite;
    }
</style>
