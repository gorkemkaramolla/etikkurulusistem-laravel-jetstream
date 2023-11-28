<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchInformations extends Model
{
    protected $fillable = ["research_title","research_subject_purpose","research_unique_value","research_hypothesis","research_method","research_universe","research_forms","research_data_collection","research_restrictions","research_place_date","research_literature_review"];

}
