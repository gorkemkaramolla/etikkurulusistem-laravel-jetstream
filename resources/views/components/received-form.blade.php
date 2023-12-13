@props(['forms'])

<!DOCTYPE html>
<html lang="en">


<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold mb-4">Onay Bekleyen Formlar</h2>
    <table id="myTable" class="table-auto w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Döküman Numarası</th>
                <th>Onay Durumu</th>
                <th>Araştırma Başlığı</th>
                <th>Araştırmacı Öğrenci No</th>
                <th>Araştırmacı Adı</th>
                <th>Araştırmacı Email</th>
                <th>Araştırmacı Telefon</th>
                <th>Tüm Başvuruyu Görüntüle</th>
                <th>Onay</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
                <tr>

                    <td class="border px-4 py-2">{{ $form['id'] }}</td>
                    <td class="border px-4 py-2">{{ $form['document_number'] }}</td>
                    <td class="border px-4 py-2">{{ $form['stage'] }}</td>
                    <td class="border px-4 py-2">{{ $form['research_informations']['research_title'] }}
                    <td class="border px-4 py-2">{{ $form['researcher_informations']['student_no'] }}</td>
                    <td class="border px-4 py-2">{{ $form['researcher_informations']['name'] }}</td>
                    <td class="border px-4 py-2">{{ $form['researcher_informations']['email'] }}</td>
                    <td class="border px-4 py-2">{{ $form['researcher_informations']['gsm'] }}</td>

                    <td class="border px-4 py-2">
                        <a target="_blank"
                            href="/forms/{{ $form['researcher_informations']['student_no'] }}/{{ \Carbon\Carbon::parse($form['created_at'])->format('d-m-Y-His') }}"
                            class="text-blue-400">Görüntüle</a>
                    </td>
                    @foreach ($forms as $form)
                        <td class="border px-4 py-2">
                            @if (auth()->user()->hasRole('sekreterlik'))
                                @if ($form->etik_kurul_onayi->where('user_id', auth()->user()->id)->where('onay_durumu', 'onaylandi')->count() > 0)
                                    <span class="text-green-600">Onaylandı</span>
                                @else
                                    <a href="{{ route('approve.sekreterlik', ['formid' => $form->id]) }}"
                                        class="text-green-600">Onayla✓</a>
                                @endif
                            @elseif(auth()->user()->hasRole('etik_kurul'))
                                @php
                                    $etikKurulOnayi = $form->etik_kurul_onayi->where('user_id', auth()->user()->id)->first();
                                @endphp

                                @if ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'onaylandi')
                                    <span class="text-blue-600">Etik Kurul Onaylandı</span>
                                @else
                                    <a href="{{ route('approve.etikkurul', ['formid' => $form->id]) }}"
                                        class="text-blue-600">Etik Kurul Onayla✓</a>
                                @endif
                            @else
                                <!-- Handle other roles or no role -->
                                <span class="text-gray-500">Not applicable</span>
                            @endif
                        </td>
                    @endforeach







                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Add DataTables JS files -->
<script>
    new DataTable('#myTable', {
        scrollY: 300,
        paging: true,
        lengthMenu: [10, 25, 50, 100], // Customize the entries dropdown
        pageLength: 0,
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
</script>
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

</html>
