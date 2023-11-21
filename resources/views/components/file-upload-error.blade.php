@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->keys() as $errorKey)
            @foreach ($errors->get($errorKey) as $errorMessage)
                Dosya boyutu geçerli bir PDF olmalı ve 2048 KB'dan küçük olmalıdır
                ({{ ucfirst(str_replace('_', ' ', Str::after($errorKey, 'path_'))) }} Hatası)
                .
            @endforeach
        @endforeach
    </div>
@endif
