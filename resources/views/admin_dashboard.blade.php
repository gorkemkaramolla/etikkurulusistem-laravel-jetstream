<x-datatables-layout>
    <div class="w-full py-4  flex flex-col ">
        <div class="etik_kurul_onaylari  flex gap-2 w-full flex-wrap md:flex-row  items-center justify-center">
        </div>
        <table id="myTable" class="divide-gray-200 ">
        </table>
        <div class="flex flex-wrap gap-4 px-5">

            <x-button class=" px-4 send-mail-button hidden">Seçilenlere Mail Gönder</x-button>
            <x-button class=" delete-button hidden">Seçilenleri Sil</x-button>
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a target="_blank"
                class="show-edit-button hidden  flex items-center  py-2 px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Görüntüle/Düzenle</a>
            <a target="_blank"
                class="show-querystage-button hidden  flex items-center py-2 px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Sorgu
                Linki</a>
        </div>
    </div>
</x-datatables-layout>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #dc3545;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        background: #dc3545 !important;
        color: white !important;
    }

    li.paginate_button.page-item.active {
        background-color: #dc3545 !important;
        color: white !important;
    }
</style>



@if (session('success'))
    <script>
        Swal.fire({
            title: "Başarılı",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: 'Tamam',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: "Hata",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: 'Tamam',
        });
    </script>
@endif
<script>
    var phpForms = @json($forms);
    var turkishColumnNames = @json(config('columnnames'));
</script>
<script src="{{ asset('assets/js/dashboards.js') }}"></script>
<script src="{{ asset('assets/js/admindashboard.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
