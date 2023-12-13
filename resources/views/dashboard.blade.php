<x-app-layout>

    <head>
        <title>{{ auth()->user()->role }}</title>
    </head>
    <x-received-form :forms="$forms" />

    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
    @else
        <p>Unauthorized access to the dashboard.</p>
    @endif
    </div>
    <script></script>
</x-app-layout>
