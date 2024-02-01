<x-datatables-layout>

    <head>
        <title>{{ auth()->user()->role === 'sekreterlik' ? 'Sekreterlik Üyesi' : 'Etik Kurulu Üyesi' }}</title>
    </head>
    <div id="loading">loading...</div>
    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
        <div class="w-full py-4  flex flex-col ">
            <select class="mx-auto filterStage" name="status" id="">
                <option {{ auth()->user()->role === 'admin' ? 'selected' : null }} value="all">
                    <h1>Tüm Başvurular</h1>
                </option>
                @if (auth()->user()->role === 'sekreterlik')
                    <option {{ auth()->user()->role === 'sekreterlik' ? 'selected' : null }} value="sekreterlik">
                        <h1>Sekreterlik Onayı Bekleyen Başvurular</h1>
                    </option>
                @elseif(auth()->user()->role === 'etik_kurul')
                    <option value="etik_kurul">
                        <h1>Etik Kurul Onayı Bekleyen Başvurular</h1>
                    </option>
                    <option {{ auth()->user()->role === 'etik_kurul' ? 'selected' : null }} value="user_onay_bekleyen">
                        <h1>Etik Kurul Oyunuzu Bekleyen Başvurular</h1>
                    </option>
                @endif
                <option value="onaylandi">
                    Onaylanan Başvurular
                </option>
                <option value="duzeltme">
                    Düzeltme Bekleyen Gereken Başvurular
                </option>
                <option value="reddedildi">
                    Reddedilen Başvurular
                </option>

            </select>
            @if (count($forms) > 0)
                <table id="myTable" class="divide-gray-200 ">
                </table>
            @else
                <div class="flex items-center justify-center h-[75vh]">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold mb-4">Görüntüleyebileceğiniz başvuru bulunmamaktadır</h2>
                        <p class="text-gray-500">Lütfen daha sonra tekrar deneyin.</p>
                    </div>
                </div>
            @endif
            <div class="flex  gap-4 px-5">
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
            <div class="etik_kurul_onaylari  flex gap-2 w-full flex-wrap md:flex-row my-4 items-start justify-center">
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
            var csrfToken = "{{ csrf_token() }}";
            var user_id = "{!! Auth::user()->id !!}";
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
