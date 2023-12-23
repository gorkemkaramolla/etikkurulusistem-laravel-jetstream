<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherInformations extends Model
{
    protected $fillable = ['name', "lastname", "advisor", "gsm", "email", "major", "department", "student_no"];
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
    public function researcher_informations()
    {
        return $this->hasOne(ResearcherInformations::class);
    }
}
