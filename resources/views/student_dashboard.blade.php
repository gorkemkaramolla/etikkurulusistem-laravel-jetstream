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
        <h2 class="text-xl self-start font-extrabold">Tüm Başvuruların</h2>

        <div class="w-full h-full flex flex-col gap-4  itesm-start md:items-center flex-wrap justify-start">
            @if (count($forms) !== 0)
                @foreach ($forms as $form)
                    <div class="bg-white  border-4 rounded-lg  md:w-1/2 w-full ">

                        @if ($form->stage === 'duzeltme')
                            <div class="bg-orange-100  m-4 border-l-4 flex flex-col items-start justify-start border-orange-500 text-orange-700 p-4"
                                role="alert">
                                <p class="font-bold">Başvurunuz düzeltmeye gönderildi</p>
                                <a class="animate-pulse " href="/form/{{ $form->id }}"
                                    class=" text-orange-600 hover:text-orange-700 transition-colors font-bold  flex justify-center rounded">Formu
                                    Düzelt

                                </a>
                            </div>
                        @endif
                        <div class="px-4 py-5   flex flex-col ">

                            <div class="flex p-2 rounded-md bg-gray-100 justify-between mb-3">
                                <h3 class=" text-gray-900">
                                    Döküman Numarası: {{ $form->id }}
                                </h3>
                                <p class="text-gray-700">
                                    Gönderilme Tarihi: {{ $form->created_at->format('d-m-Y') }}
                                </p>
                            </div>
                            <p class="text-gray-700 break-words bg-gray-100 font-bold text-2xl">
                                {{ $form->research_title }}
                            </p>
                        </div>
                        <div class="flex gap-2 justify-center my-2">
                            <a target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                href="{{ url('/show-pdf/' . $form->onam_path) }}">
                                Gönüllü Onam Formu
                            </a>
                            <a target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                href="{{ url('/show-pdf/' . $form->anket_path) }}">
                                Anket Formu
                            </a>
                            @if ($form->kurum_izinleri_path)
                                <a target="_blank"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                    href="{{ url('/show-pdf/' . $form->kurum_izinleri_path) }}">

                                    Kurum İzinleri
                                </a>
                            @endif
                        </div>
                        <div class="px-4 py-4 flex justify-between bg-gray-100">
                            <a target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                href="/formshow/{{ $form->student_no ?? '' }}/{{ $form->created_at }}">
                                Tüm Başvuruyu Görüntüle
                            </a>
                            <x-forms.form-status :formid="$form->id" :stage="$form->stage" :decide_reason="$form->decide_reason" />

                        </div>
                    </div>
                @endforeach
            @else
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                    Hiç başvurunuz bulunmamaktadır.

                </div>
            @endif
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
