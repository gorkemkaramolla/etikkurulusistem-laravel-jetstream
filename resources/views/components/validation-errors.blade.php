@if ($errors->any())
    <div {{ $attributes }}>
        @if (session('login_error'))
            <div class="font-medium text-red-600">{{ session('login_error') }}</div>
        @else
            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
        @endif

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
