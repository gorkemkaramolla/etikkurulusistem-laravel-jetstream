<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['name'];
    protected $fillable = ['tc_kimlik_no'];
    protected $fillable = ['calisma_programı'];
    protected $fillable = ['calisma_basligi'];
}
