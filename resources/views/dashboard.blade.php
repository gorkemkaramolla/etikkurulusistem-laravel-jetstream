<x-app-layout class="flex items-center justify-center">
    <x-received-form :forms="$forms" />

    <div class="flex w-full h-full justify-center items-center">
        @if (auth()->user()->hasRole('sekreterlik') ||
                auth()->user()->hasRole('etik_kurul'))
        @else
            <p>Unauthorized access to the dashboard.</p>
        @endif
    </div>
    </div>

</x-app-layout>
