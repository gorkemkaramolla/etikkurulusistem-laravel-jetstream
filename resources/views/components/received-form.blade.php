@props(['forms'])

<div class="overflow-x-scroll">
    <table class="table-auto  ">
        <thead>
            @if ($forms !== null && count($forms) > 0)
                <h1 class="p-8">
                    ONAY BEKLEYEN FORMLAR
                </h1>
                <tr class="">
                    @foreach ($forms[0]->getAttributes() as $columnName => $columnValue)
                        <th class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                            {{ ucfirst(Str::snake($columnName, ' ')) }}
                        </th>
                    @endforeach
                    <th class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            @else
                <h1>
                    ONAY BEKLEYEN FORM BULUNMAMAKTADIR.
                </h1>
            @endif
        </thead>
        <tbody>
            @foreach ($forms as $form)
                <tr class="bg-white hover:bg-gray-100">
                    @foreach ($form->getAttributes() as $columnName => $columnValue)
                        <td class="px-2 text-center text-sm py-1 text-gray-800 border border-b">
                            @if (Str::startsWith($columnName, 'path_'))
                                @php
                                    // Remove "public/" from the beginning of the path
                                    $relativePath = Str::after($columnValue, 'public/');
                                    $url = asset('storage/' . $relativePath);
                                @endphp
                                <a target="_blank" href="{{ $url }}"
                                    class="text-blue-500 hover:underline">dosya</a>
                            @else
                                {{ $columnValue }}
                            @endif
                        </td>
                    @endforeach
                    <td class="p-3 flex flex-col gap-3">
                        <form action="{{ url('/forms/approve/' . $form->id) }}" method="post">
                            @csrf
                            <input type="submit" value="onay"
                                class="w-full capitalize px-2 py-1 hover:transition-color ring-green-400 ring-2">
                        </form>
                        <form action="">
                            <button type="submit" value="düzeltme" type="submit"
                                class="w-full capitalize px-2 py-1 flex justify-center hover:transition-colors ring-blue-400 ring-2">
                                <x-gmdi-delete-r class="w-6 h-6" />
                            </button>
                        </form>
                        <form action="">
                            <input type="submit"
                                class="w-full capitalize px-2 py-1 hover:transition-colors ring-blue-400 ring-2">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
