@props(['forms'])

<style>
    table {
        min-height: 100%;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #e5e7eb;
        padding: 20px;

    }

    th {
        background-color: slateblue;
        color: #fff;
        font-weight: bold;
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th.sorting:after {
        color: #ccc;
    }

    th.sorting:before {
        color: #ccc;
    }
</style>
<div class=" min-h-[500px] overflow-x-auto px-4 sm:px-6 lg:px-8 py-8">

    <h2 class="text-2xl font-bold mb-4">
        @if (request()->segment(2) === 'duzeltme')
            Düzeltilmeye Gönderilen Başvurular
        @elseif (request()->segment(2) === 'reddedildi')
            Reddedilmiş Başvurular
        @else
            Onay Bekleyen Başvurular
        @endif
    </h2>





    <table id="myTable" class="min-w-full   divide-y divide-gray-200">
        <thead>
            <tr>
                <th onclick="clickHandler(0)">ID</th>
                <th onclick="clickHandler(1)">Tarih</th>
                <th onclick="clickHandler(2)">Öğrenci No</th>
                <th onclick="clickHandler(3)">Adı</th>
                <th onclick="clickHandler(4)">Email</th>
                <th onclick="clickHandler(5)">Telefon</th>
                <th onclick="clickHandler(6)">Dosyalar</th>
                <th onclick="clickHandler(7)">Tümünü Görüntüle</th>
                <th onclick="clickHandler()">Onay</th>


            </tr>
        </thead>
        <tbody>
            @if ($forms->count() !== 0)
                @foreach ($forms as $form)
                    <tr>
                        <td class="transition-colors ">{{ $form['id'] ?? 'N/A' }}</td>
                        <td class="transition-colors ">
                            {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') ?? 'N/A' }}
                        </td>
                        <td class="transition-colors ">{{ $form['student_no'] ?? 'N/A' }}
                        </td>
                        <td class="transition-colors ">{{ $form['name'] ?? 'N/A' }}
                            {{ $form['lastname'] ?? 'N/A' }}</td>
                        <td class="transition-colors ">{{ $form['email'] ?? 'N/A' }}</td>
                        <td class="transition-colors ">{{ $form['gsm'] ?? 'N/A' }}</td>
                        <td class="transition-colors ">


                        </td>

                        <td class="transition-colors ">


                            <div class="flex flex-col ">
                                <a target="_blank"
                                    class="inline-flex items-center px-3 py-2  -transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                    href="/formshow/{{ $form['id'] ?? '' }}">Görüntüle/Show</a>
                            </div>


                        </td>
                        <td>
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
                @endforeach
            @else
            @endif
        </tbody>
    </table>

    <div>
        @if (request()->segment(2) !== 'reddedildi')
            <a href="{{ route('dashboard', ['formStatus' => 'reddedildi']) }}" class="text-blue-500 hover:underline">
                Reddedilmiş Başvuruları Görüntüle
            </a>
        @endif

        @if (request()->segment(2) !== 'duzeltme')
            <a href="{{ route('dashboard', ['formStatus' => 'duzeltme']) }}" class="text-blue-500 hover:underline ml-4">
                Düzeltmeye Gönderilen Başvuruları Görüntüle
            </a>
        @endif

        @if (!empty(request()->segment(2)))
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline ml-4">
                Onay Bekleyen Başvuruları Görüntüle
            </a>
        @endif
    </div>

    {{-- <div class="flex flex-wrap gap-4 ">
        @if ($forms->count() !== 0)
            @foreach (array_keys($forms->first()->toArray()) as $columnName)
                <button class="text-gray-700 border-2 p-2" onclick="selectColumn(this)"
                    class="p-2 text-sm">{{ $columnName }}</button>
            @endforeach
        @endif

        <button class="text-green-500" onclick="exportSelectedColumns()" class="p-2 text-sm">Export Selected</button>
    </div> --}}
</div>


<style type="text/css" class="init">

</style>

<script type="text/javascript" class="init">
    $.fx.off = true
    $(document).ready(function() {
        var dataTable = $('#myTable').DataTable({
            dom: 'Bfrtip',
            responsive: true,

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        var selectedColumns = dt.columns(':visible').indexes().toArray();
                        if (selectedColumns.length === 0) {
                            Swal.fire({
                                title: "Hata",
                                text: "Lütfen excel'e aktarım için en az bir sütun seçin.",
                                icon: "error",
                                confirmButtonText: 'Tamam',
                            });
                        } else {
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt,
                                button, config);
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        var selectedColumns = dt.columns(':visible').indexes().toArray();
                        if (selectedColumns.length === 0) {
                            Swal.fire({
                                title: "Hata",
                                text: "Lütfen pdf'e aktarım için en az bir sütun seçin.",
                                icon: "error",
                                confirmButtonText: 'Tamam',
                            });
                        } else {
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button,
                                config);
                        }
                    }
                },

                {
                    extend: 'colvis',
                    text: "Sütun Görünürlüğü",
                    columnText: function(dt, idx, title) {
                        return (idx + 1) + '- ' + title;
                    },


                }
            ],


            scrollX: true,
        });
    });
</script>

<style>
    .buttons-colvis {
        background-color: #e44d26;
        color: #fff;
    }

    .dropdown-item {
        padding: 2px 16px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .buttons-colvis {
        background-color: #e44d26;
        color: #fff;
    }


    /* Custom animation delay for DataTables ColVis */
    .dataTables_wrapper .ColVis_MasterButton {
        transition-delay: 0.1s;
        /* Adjust the delay time as needed */
    }

    .dt-button-background {
        background-color: red
    }

    div[role="menu"] {
        position: absolute;
        margin-top: 1rem;

        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 0.5rem;
        z-index: 100;
        background-color: white;
        padding: 5px;
        border-radius: 16px;

    }

    a.dt-button.dt-button-active {
        border-radius: 10px;
        color: #28a745;
    }



    .dt-buttons {
        display: flex;
        gap: 1em;
    }

    .dt-buttons .btn {
        background: #092635;
        padding: 6px 12px;
        color: white;
        border-radius: 20px;


    }

    /* Customize the colvis button */
    .buttons-colvis {
        transition: opacity 0.5s ease;
        /* Change the transition properties as needed */
    }

    .buttons-colvis:hover {
        opacity: 0.8;
        /* Change the opacity value for the hover effect */
    }

    /* Customize the colvis dropdown transition */
    .dt-buttons .buttons-columnVisibility.dropdown {
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Adjust the transition properties */
    }

    .dt-buttons .buttons-columnVisibility.dropdown:hover {
        opacity: 1;
        /* Change the opacity value for the hover effect */
        transform: scale(1.05);
        /* Change the scale value for the hover effect */
    }

    a.dt-button:not(.dt-button-active) {
        border-radius: 4px;
    }

    a.dt-button.dt-button-active:after {
        content: '\2713';
        font-size: 1.2em;
        color: black;
        margin-left: 8px;
    }

    #myTable_filter {
        padding: 20px 0px;
    }

    a.dt-button span {
        flex: 1;
    }

    .dataTables_wrapper .dt-buttons .buttons-columnVisibility.dropdown-item input[type="checkbox"] {
        display: none;
    }


    .dataTables_wrapper .dt-buttons .buttons-columnVisibility.dropdown-item:hover {
        background-color: rgb(241, 241, 241);
        border-radius: 10px;

        color: #28a745;
    }
</style>
