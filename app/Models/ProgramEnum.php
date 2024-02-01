<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramEnum extends Model
{
    use HasFactory;

    protected $table = 'programs_enum';

    protected $casts = [
        'fields' => 'array',
    ];
}
