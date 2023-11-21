<!-- resources/views/components/received-form.blade.php -->

@props(['forms'])
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <h1 class="p-8">
                ONAY BEKLEYEN FORMLAR

            </h1>
            <div class="overflow-hidden px-8">
                <table class="table-auto overflow-x-auto w-1/2">
                    <thead>
                        @if ($forms !== null && count($forms) > 0)
                            <tr class="">
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">isim</th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">soyisim</th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">email</th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Öğrenci
                                    No</th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Başvuru
                                    Tarihi
                                </th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Başvuru
                                    Formu
                                </th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Ölçek
                                    İzinleri Formu
                                </th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Anket Formu
                                </th>
                                <th class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase">Gönüllü
                                    Onam Formu
                                </th>









                            </tr>
                        @endif
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
