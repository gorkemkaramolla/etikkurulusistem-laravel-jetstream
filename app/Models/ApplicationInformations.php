<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationInformations extends Model
{
    protected $fillable = ["application_semester","academic_year","application_type","work_qualification","research_type","institution_permission",'research_start_date','research_end_date'];
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
