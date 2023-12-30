<x-app-layout>
    <div class="w-full h-full flex-col flex justify-center items-center">
        <div
            class="slide-down announcement w-full flex items-center justify-between gap-4 bg-indigo-600 px-4 py-3 text-white">
            <p class="text-sm font-medium">
                Etik Kurul Sistemi Yenilendi!&nbsp;
                <a href="#" class="inline-block underline"> Bilgi için tıklayınız</a>
            </p>

            <button onclick="hideAnnouncement()" aria-label="Dismiss"
                class="shrink-0 rounded-lg bg-black/10 p-1 transition hover:bg-black/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <h2 class="text-xl self-start font-extrabold">Güncel Başvurularınız</h2>

        <div class="w-full h-full flex  justify-start">
            @foreach ($forms as $form)
                <div class="bg-white shadow-lg rounded-lg  m-4 w-full sm:w-3/4 md:w-1/2 lg:w-1/ 3">

                    <div class="px-4 py-5   flex flex-col gap-2">

                        <div class="flex p-2 rounded-md bg-gray-100 justify-between mb-3">
                            <h3 class=" text-gray-900">
                                Döküman Numarası: {{ $form->id }}
                            </h3>
                            <p class="text-gray-700">
                                Gönderilme Tarihi: {{ $form->created_at->format('d-m-Y') }}
                            </p>
                        </div>
                        <p class="text-gray-700 font-bold text-2xl">
                            {{ $form->research_title }}
                        </p>
                    </div>
                    <div class="px-4 py-4 flex justify-between bg-gray-100">
                        <a target="_blank"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                            href="/formshow/{{ $form->student_no ?? '' }}">
                            Tüm Başvuruyu Görüntüle
                        </a>
                        <x-forms.form-status :stage="$form->stage" :decide_reason="$form->decide_reason" />

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function hideAnnouncement() {
            $('.announcement').hide();
        }
    </script>
    <style>
        @keyframes slide-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-down {
            animation: slide-down 0.5s ease-out;
        }
    </style>
</x-app-layout>
