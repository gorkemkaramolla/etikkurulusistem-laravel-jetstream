<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxFileSize implements ValidationRule
{

   

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value->getSize() / 1024 <= 4)
        {
            $fail("Dosya yükleme 2MB ile sınırlıdır");
        }

    }
}
