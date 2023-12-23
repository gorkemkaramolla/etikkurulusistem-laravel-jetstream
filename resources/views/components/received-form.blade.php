@props(['forms'])
<style>
</style>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold mb-4">
        @if (request()->query('onaylandi') === 'true')
            Onaylanmış Formlar
        @else
            Onay Bekleyen Formlar
        @endif
    </h2>

    <table id="myTable" class="table-auto w-full">
        <thead>
            <tr>
                <th>Döküman Numarası</th>
                <th>Onay Durumu</th>
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
                        <td class="border px-4 py-2">{{ $form['id'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $form['stage'] ?? 'N/A' }}</td>

                        <td class="border px-4 py-2">{{ $form['researcher_informations']['student_no'] ?? 'N/A' }}
                        </td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['name'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['email'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['gsm'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            @if ($form && $form->onam_path)
                                <div>
                                    <a class="text-blue-400" href="{{ url('/show-pdf/' . $form->onam_path) }}"
                                        target="_blank">Gönüllü Onam Formu</a>

                                </div>
                            @endif
                            <hr>
                            @if ($form && $form->kurum_izinleri_path)
                                <div>

                                    <a class="text-blue-400" href="{{ url('/show-pdf/' . $form->kurum_izinleri_path) }}"
                                        target="_blank">Kurum İzinleri</a>
                                </div>
                            @endif
                            <hr>
                            @if ($form && $form->anket_path)
                                <div>

                                    <a class="text-blue-400" href="{{ url('/show-pdf/' . $form->anket_path) }}"
                                        target="_blank">Anket Formu</a>
                                </div>
                            @endif
                        </td>

                        <td class="border px-4 py-2">
                            <a target="_blank"
                                href="/formshow/{{ $form['researcher_informations']['student_no'] ?? '' }}"
                                class="text-blue-400">Görüntüle/Show</a>

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

    <a href="#" id="toggleForms" data-value="{{ request()->query('onaylandi') === 'true' ? 'false' : 'true' }}">
        @if (request()->query('onaylandi') === 'true')
            Onay bekleyen formları görüntüle
        @else
            Onaylanmış formları görüntüle
        @endif
    </a>

    @if (
        $forms->count() !== 0 &&
            auth()->user()->hasRole('etik_kurul'))
        @if ($etikKurulOnayi && $etikKurulOnayi->onay_durumu === 'onaylandi')
            <span class="text-green-600">Onayladığınız başvurular diğer kurul üyelerinin sonucunda
                sonuçlanacaktır.</span>
        @endif
    @endif
</div>

<script>
    $('#myTable').DataTable({
        scrollY: 600,
        paging: true,
        lengthMenu: [10, 25, 50, 100],
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
<script>
    // Function to toggle input visibility and disabled attribute based on the selected radio button
    function toggleInputVisibility() {
        const radioButtons = document.getElementsByName('decide');
        const inputElement = document.getElementById('decide-reason-input');

        // Loop through radio buttons to find the selected one
        for (const radioButton of radioButtons) {
            if (radioButton.checked) {
                // Show the input only if a non-"Onay" radio button is selected
                const isOnay = radioButton.value === 'onaylandi';
                inputElement.style.display = isOnay ? 'none' : 'block';

                // Set the 'disabled' attribute based on whether the input should be included in the form submission
                inputElement.disabled = isOnay;
                return;
            }
        }

        inputElement.style.display = 'none';
        inputElement.disabled = true;
    }

    const radioButtons = document.getElementsByName('decide');
    for (const radioButton of radioButtons) {
        radioButton.addEventListener('change', toggleInputVisibility);
    }

    toggleInputVisibility();
</script>


<script>
    var openmodal = document.querySelectorAll('.modal-open')
    for (var i = 0; i < openmodal.length; i++) {
        openmodal[i].addEventListener('click', function(event) {
            event.preventDefault()
            toggleModal()
        })
    }

    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal)

    var closemodal = document.querySelectorAll('.modal-close')
    for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', toggleModal)
    }

    document.onkeydown = function(evt) {
        evt = evt || window.event
        var isEscape = false
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc")
        } else {
            isEscape = (evt.keyCode === 27)
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal()
        }
    };


    function toggleModal() {
        const body = document.querySelector('body')
        const modal = document.querySelector('.modal')
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }
</script>

</html>
