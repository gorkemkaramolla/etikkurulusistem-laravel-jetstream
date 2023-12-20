@props(['forms'])

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
            @if ($forms->count() !== 0)
                @foreach ($forms as $form)
                    <tr>
                        <td class="border px-4 py-2">{{ $form['id'] }}</td>
                        <td class="border px-4 py-2">{{ $form['stage'] }}</td>
                        <td class="border px-4 py-2">{{ $form['research_informations']['research_title'] }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['student_no'] }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['name'] }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['email'] }}</td>
                        <td class="border px-4 py-2">{{ $form['researcher_informations']['gsm'] }}</td>
                        <td class="border px-4 py-2">
                            <a target="_blank"
                                href="/forms/{{ $form['researcher_informations']['student_no'] }}/{{ \Carbon\Carbon::parse($form['created_at'])->format('d-m-Y-His') }}"
                                class="text-blue-400">Görüntüle/Show</a>
                        </td>
                        <td class="flex items-center justify-center flex-col">
                            @if (auth()->user()->hasRole('sekreterlik') && $form->stage === 'sekreterlik')
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
        scrollY: 300,
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
    $('#toggleForms').click(function(e) {
        e.preventDefault();

        // Toggle the data-value attribute
        var onaylandiValue = $(this).data('value') === 'true' ? 'false' : 'true';

        // Show loading indicator
        $('#myTable').html('<p>Loading...</p>');

        // Construct the URL based on the condition
        var url = onaylandiValue === 'true' ? '/dashboard?onaylandi=true' : '/dashboard';

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#myTable')) {
            // Destroy the existing DataTable
            $('#myTable').DataTable().destroy();
        }

        // Make an AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                // Update the content with the response
                $('#myTable').html($(data).find('#myTable').html());

                // Reinitialize DataTable
                $('#myTable').DataTable({
                    scrollY: 300,
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

                // Update the link's data-value attribute
                $('#toggleForms').data('value', onaylandiValue);

                // Update the browser's URL without reloading the page
                var newURL = onaylandiValue === 'true' ? '/dashboard?onaylandi=true' : '/dashboard';
                window.history.pushState({}, document.title, newURL);

                // Update the h2 element based on onaylandiValue
                $('h2').text(onaylandiValue === 'true' ? 'Onaylanmış Formlar' :
                    'Onay Bekleyen Formlar');

                // Update the button text based on onaylandiValue
                $('#toggleForms').text(onaylandiValue === 'true' ?
                    'Onay bekleyen formları görüntüle' : 'Onaylanmış formları görüntüle');
            },
            error: function(error) {
                console.error('Error:', error);
                // Handle errors if needed
                $('#myTable').html('<p>Error loading data</p>');
            }
        });
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
