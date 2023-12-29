<x-app-layout>

    <head>
        <title>{{ auth()->user()->role === 'sekreterlik' ? 'Sekreterlik Üyesi' : 'Etik Kurulu Üyesi' }}</title>
    </head>

    @if (auth()->user()->hasRole('sekreterlik') ||
            auth()->user()->hasRole('etik_kurul'))
        <x-received-form :forms="$forms" />
    @else
        <p>Unauthorized access to the dashboard.</p>
    @endif
    </div>
    <script></script>
</x-app-layout>
