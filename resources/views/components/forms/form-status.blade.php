{{-- @props(['stage', 'decide_reason' => null, 'formid'])

@if ($stage === 'sekreterlik')
    <p class="bg-blue-200 p-2 rounded-md">Form Sekreterlik Onayı Bekliyor.</p>
@elseif ($stage === 'etik kurul')
    <p class="bg-blue-200 p-2 rounded-md">Form Etik Kurulu Onayı bekliyor.</p>
@elseif ($stage === 'duzeltme')
    <div class="flex justify-between items-center flex-col bg-[#ffc107] text-black p-2 rounded-md">

        <div class="text-gray-950 ">
            <p class="">Başvurunuzu Düzeltmeniz gerekmetedir.</p>
            <p>
                @if ($decide_reason)
                    {{ $decide_reason }}
                @endif
            </p>
        </div>
        <a href="/form/{{ $formid }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 w-1/2 flex justify-center rounded">Formu
            Düzelt</a>

    </div>
@else
    <div class="bg-red-200 p-2 rounded-md">
        <div class="text-gray-950 ">
            <p class="">Başvurunuzu Reddedilmiştir.</p>
            <p>
                @if ($decide_reason)
                    {{ $decide_reason }}
                @endif
        </div>
    </div>
@endif --}}
