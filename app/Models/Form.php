<?php

// app/Models/Form.php

namespace App\Models;
use Illuminate\Support\FacadesLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Form extends Model
{
    // Define your relationships
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

    public function etik_kurul_onayi()
    {
        return $this->hasMany(EtikKurulOnayi::class, 'form_id');
    }

    public function isApprovedByEtikKurul()
    {
        $etikKurulApprovals = $this->etik_kurul_onayi->pluck('onay_durumu')->toArray();
        return count(array_unique($etikKurulApprovals)) === 1 && in_array('onaylandi', $etikKurulApprovals);
    }

    public function approveFormByEtikKurul()
    {
        if ($this->isApprovedByEtikKurul()) {
            $this->update(['stage' => 'approved']);
        }
    }

    protected static function boot()
    {
        parent::boot();

        // Deleting event will be triggered before a model is deleted
        static::deleting(function (Form $form) {
            // Log statement for debugging
            Log::info("Deleting event triggered for Form ID: {$form->id}");

            // Delete associated folder when the form is deleted
            $form->deleteAssociatedFolder();
        });
    }

    // Add a method to delete the associated folder
    public function deleteAssociatedFolder()
    {
        // Ensure the associated researcher_informations relationship is loaded
        $this->load('researcher_informations');

        // Check if researcher_informations relationship is loaded and not null
        if ($this->researcher_informations) {
            // Delete associated folder
            $studentNumber = $this->researcher_informations->student_no;
            $directory = "public/forms/{$studentNumber}";

            // Ensure the directory exists before attempting to delete
            if (Storage::exists($directory)) {
                Storage::deleteDirectory($directory);
            }
        }
    }
   
}
