@props(['forms'])


<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h2 class="text-2xl font-bold mb-4">
        @if (request()->query('onaylandi') === 'true')
            Onaylanmış Formlar
        @else
            Onay Bekleyen Formlar
        @endif
    </h2>

    <table id="myTable" class="hidden">
        <thead>
            <tr>
                <th>Döküman Numarası</th>
                <th>Gönderilme Tarihi</th>
                <th>Araştırmacı Öğrenci No</th>
                <th>Araştırmacı Adı</th>
                <th>Araştırmacı Email</th>
                <th>Araştırmacı Telefon</th>
                <th>Ek Dosyalar</th>
                <th>Tüm Başvuruyu Görüntüle</th>
                <th>Onay</th>
            </tr>
        </thead>
        <tbody>
            @if ($forms->count() !== 0)
                @foreach ($forms as $form)
                    <tr>
                        <td class="border ">{{ $form['id'] ?? 'N/A' }}</td>
                        <td class="border ">
                            {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') ?? 'N/A' }}
                        </td>
                        <td class="border ">{{ $form['student_no'] ?? 'N/A' }}
                        </td>
                        <td class="border ">{{ $form['name'] ?? 'N/A' }}
                            {{ $form['lastname'] ?? 'N/A' }}</td>
                        <td class="border ">{{ $form['email'] ?? 'N/A' }}</td>
                        <td class="border ">{{ $form['gsm'] ?? 'N/A' }}</td>
                        <td class="border ">
                            <x-dropdown align="left" width="60">
                                <x-slot name="trigger">

                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  transition ease-in-out duration-150">
                                            Formları Görüntüle


                                        </button>
                                    </span>

                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60 ">
                                        @if ($form && $form->onam_path)
                                            <div>
                                                <x-dropdown-link href="{{ url('/show-pdf/' . $form->onam_path) }}"
                                                    target="_blank">Gönüllü Onam Formu</x-dropdown-link>

                                            </div>
                                        @endif
                                        <hr>
                                        @if ($form && $form->kurum_izinleri_path)
                                            <div>

                                                <x-dropdown-link
                                                    href="{{ url('/show-pdf/' . $form->kurum_izinleri_path) }}"
                                                    target="_blank">Kurum İzinleri</x-dropdown-link>
                                            </div>
                                        @endif
                                        <hr>
                                        @if ($form && $form->anket_path)
                                            <div>

                                                <x-dropdown-link href="{{ url('/show-pdf/' . $form->anket_path) }}"
                                                    target="_blank">Anket Formu</x-dropdown-link>
                                            </div>
                                        @endif
                                </x-slot>
                            </x-dropdown>


                        </td>

                        <td class="border ">


                            <div class="flex flex-col ">
                                <a target="_blank"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                    href="/formshow/{{ $form['student_no'] ?? '' }}">Görüntüle/Show</a>
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
                            @endif
                        </td>

                    </tr>
                @endforeach
            @else
            @endif
        </tbody>
    </table>



    @if (
        $forms->count() !== 0 &&
            auth()->user()->hasRole('etik_kurul'))
        @if ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'onaylandi')
            <span class="text-green-600">Onayladığınız başvurular diğer kurul üyelerinin sonucunda
                sonuçlanacaktır.</span>
        @endif
    @endif
</div>




<style>
    /* Remove all styling applied to DataTables length select */
    .dataTables_length select {
        padding-left: 10px !important;
        padding-right: 20px !important;
        background-position: right;
    }

    /* Optional: Style the dropdown options */
    .dataTables_length select option {
        /* Add any additional styling you need here */
    }
</style>
<script>
    const myTable = $('#myTable').DataTable({
        scrollY: 550,
        scrollCollapse: true,
        paging: true,
        lengthMenu: [10, 25, 50, 100],
        pageLength: 0,
        order: [
            [1, 'desc']
        ], // Default sorting by the second column in descending order
        language: {
            "lengthMenu": '<select class="selectx2">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">All</option>' +
                '</select> adet gösteriliyor. '
        }
    });

    // Add event listener for DataTable draw event
    myTable.on('draw', function() {
        toggleInputVisibility();
    });
    $('#myTable').removeClass('hidden');
</script>
