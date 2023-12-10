<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ["document_number"];
    public function research_informations()
    {
        return $this->hasOne(ResearchInformations::class);
    }
    public function application_informations()
    {
        return $this->hasOne(ApplicationInformations::class);
    }
    public function researcher_informations()
    {
        return $this->hasOne(ResearcherInformations::class);
    }
    
}
