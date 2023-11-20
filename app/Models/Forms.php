<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = ['name',"lastname","ogrenci_no","path_basvuru_form","path_gonullu_onam_form","path_anket_form","path_olcek_izinleri_form"];
   
}
