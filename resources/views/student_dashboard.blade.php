<x-app-layout>
    <div class="w-full h-full  flex-col flex justify-center items-center">
        <div class="w-full announcement">
            <div
                class="slide-down my-1  w-full flex items-center justify-between gap-4 bg-custom-red px-4 py-3 text-white">
                <p class="text-sm font-medium">
                    Etik Kurul Sistemi Yenilendi!&nbsp;
                    <a href="/info" class="inline-block underline"> Bilgi için tıklayınız</a>
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
        </div>
        <h2 class="text-xl  self-start font-extrabold">Tüm Başvuruların</h2>
        <div
            class="w-full h-full my-4 flex   flex-col  gap-4 p-4  items-center md:items-center flex-wrap justify-start">
            @if (count($forms) !== 0)
                @foreach ($forms as $form)
                    <div
                        class="rounded-lg w-[100%]  md:w-[900px]  flex flex-col justify-start  overflow-y-auto bg-white p-2 border-2 {{ $form->stage === 'etik_kurul' ? 'border-blue-400' : ($form->stage === 'sekreterlik' ? 'border-purple-400' : ($form->stage === 'onaylandi' ? 'border-green-400' : ($form->stage === 'reddedildi' ? 'border-red-400' : 'border-orange-400'))) }}  ">

                        @if ($form->stage === 'duzeltme')
                            <div class="bg-orange-100   m-4 border-l-4 flex flex-col items-start justify-start border-orange-500 text-orange-700 p-4"
                                role="alert">
                                <p class="font-bold">Başvurunuzu Düzeltmeniz Gerekmektedir</p>
                                <a class="animate-pulse " href="/form/{{ $form->id }}"
                                    class=" text-orange-600 hover:text-orange-700 transition-colors font-bold  flex justify-center rounded">Başvuruyu
                                    Düzelt
                                </a>
                            </div>
                        @endif
                        @if ($form->stage === 'etik_kurul')
                            <h2 class="p-2 rounded-md mb-3 bg-blue-600 text-white">
                                Başvurunuz Etik Kurul Değerlendirmesinde
                            </h2>
                        @elseif ($form->stage === 'sekreterlik')
                            <h2 class="p-2 rounded-md mb-3 bg-purple-600 text-white">
                                Başvurunuz Sekreterlik Değerlendirmesinde
                            </h2>
                        @elseif($form->stage === 'onaylandi')
                            <h2 class="p-2 rounded-md mb-3 bg-green-600 text-white">
                                Başvurunuz Onaylandi
                            </h2>
                        @elseif($form->stage === 'reddedildi')
                            <h2 class="p-2 rounded-md mb-3 bg-red-600 text-white">
                                Başvurunuz Reddedildi
                                Red Gerekçesi: {{ $form->decide_reason }}
                            </h2>
                        @endif
                        <div
                            class="flex justify-between p-2  bg-gray-100  mb-3   rounded-md px-3 py-2 text-sm font-semibold text-gray-700 mr-2 ">
                            <h3 class=" text-gray-900">
                                Döküman Numarası: {{ $form->id }}
                            </h3>
                            <p class="text-gray-700">
                                Gönderilme Tarihi: {{ $form->created_at->format('d-m-Y') }}
                            </p>
                        </div>
                        <div class="bg-gray-100  mb-3   rounded-md px-3 py-2 text-sm font-semibold text-gray-700 mr-2">
                            <span>
                                Araştırma Başlığı :
                            </span>
                            {{ $form->research_title }}
                        </div>
                        <div class="flex gap-2 justify-center flex-col p-2 rounded-md bg-gray-100  mb-3">
                            <h3 class="text-center text-lg font-bold text-gray-900">Ek Dosyalarınız</h3>
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
                        <div class="bg-gray-100  mb-3   rounded-md px-3 py-2 text-sm font-semibold text-gray-700 mr-2">
                            <a target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                href="/formshow/{{ $form->id ?? '' }}">
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
