<x-datatables-layout>

    <head>
        <title>{{ auth()->user()->role === 'sekreterlik' ? 'Sekreterlik Üyesi' : 'Etik Kurulu Üyesi' }}</title>
    </head>

    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
        <div class="w-full py-4  flex flex-col ">

            <table id="myTable" class="divide-gray-200 ">
            </table>
            <div class="flex  gap-4 px-5">
                <div style="display: flex; align-items:center; justify-content:center;" id="emailModal"
                    class="modal absolute inset-0 bg-black bg-opacity-50 ">

                    <div class="bg-white flex items-center justify-center p-6 rounded shadow-lg relative transform ">
                        <button class="close absolute right-4 text-2xl top-2">×</button>

                        <div>
                            <form id="emailForm" class="p-4">
                                @csrf
                                <label id="emailAddresses">Email Addresses:
                                </label>
                                <textarea name="email-content" class="w-full h-16 p-2  resize-none"></textarea>
                                <button type="submit" class="mt-4 bg-indigo-600 text-white p-2 rounded">Send
                                    Email</button>
                            </form>
                        </div>
                    </div>
                </div>

                <x-button class=" px-4 send-mail-button hidden">Seçilenlere Mail Gönder</x-button>
                <div class="onay-div " id="approveModal" hidden">

                </div>
                {{-- <form id="deleteForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form> --}}
                <a target="_blank"
                    class="show-edit-button hidden  flex items-center  px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Görüntüle/Karar</a>
            </div>
            <div
                class="etik_kurul_onaylari  flex gap-2 w-full flex-wrap md:flex-row flex-col items-center justify-center">
            </div>

        </div>

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
        <script>
            var phpForms = @json($forms);
            var turkishColumnNames = @json(config('columnnames'));
        </script>
        <script src="{{ asset('assets/js/dashboards.js') }}"></script>

        <script src="{{ asset('assets/js/dashboard.js') }}"></script>

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

        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @else
        <p>Unauthorized access to the dashboard.</p>
    @endif
    </div>
    <script></script>
</x-datatables-layout>
