<x-app-layout>
    <div class="dark:bg-red-500 bg-blue-200">asda</div>
    <x-received-form :forms="$forms" />

    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
    @else
        <p>Unauthorized access to the dashboard.</p>
    @endif
    </div>

</x-app-layout>
