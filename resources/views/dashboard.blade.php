<x-app-layout>
    <x-received-form :forms="$forms" />

    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
    @else
        <p>Unauthorized access to the dashboard.</p>
    @endif
    </div>

</x-app-layout>
