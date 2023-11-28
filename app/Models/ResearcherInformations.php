<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherInformations extends Model
{
    protected $fillable = ['name',"lastname","advisor","gsm","email","major","department","student_no"];

}
