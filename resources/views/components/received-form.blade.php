<!-- resources/views/components/received-form.blade.php -->

@props(['forms'])
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="table-auto overflow-x-auto w-1/2">
                    <thead>
                        <tr class="">
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">id</th>

                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">isim</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">soyisim
                            </th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">e-mail
                            </th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">öğrenci_no
                            </th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Başvuru
                                formu</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Gönüllü
                                onam formu</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Anket
                                formu</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Ölçek
                                İzinleri Formu</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Başvuru
                                Tarihi</th>
                            <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Düzenlenme Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $form)
                            <tr class="bg-white hover:bg-gray-100">
                                @foreach ($form->getAttributes() as $columnName => $columnValue)
                                    <td class="px-2  text-sm py-1 text-gray-800 border border-b">
                                        @if (Str::startsWith($columnName, 'path_'))
                                            @php
                                                // Remove "public/" from the beginning of the path
                                                $relativePath = Str::after($columnValue, 'public/');
                                                $url = asset('storage/' . $relativePath);
                                            @endphp
                                            <a href="{{ $url }}"
                                                class="text-blue-500 hover:underline">dosya</a>
                                        @else
                                            {{ $columnValue }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
