<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = ['name',"tc_kimlik_no","calisma_programi",'calisma_basligi',"path_gonullu_onam_form","path_anket_form","path_olcek_izinleri_form"];
   
}
