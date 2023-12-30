<?php

// app/Models/Form.php

namespace App\Models;

use Illuminate\Support\FacadesLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Form extends Model
{
    protected $fillable = [
        'stage',
        'decide_reason',
        'anket_path',
        'onam_path',
        'kurum_izinleri_path',
        'application_semester',
        'temel_alan_bilgisi',
        'academic_year',
        'application_type',
        'work_qualification',
        'research_type',
        'institution_permission',
        'research_start_date',
        'research_end_date',
        'name',
        'lastname',
        'advisor',
        'gsm',
        'email',
        'major',
        'department',
        'student_no',
        'research_title',
        'research_subject_purpose',
        'research_unique_value',
        'research_hypothesis',
        'research_method',
        'research_universe',
        'research_forms',
        'research_data_collection',
        'research_restrictions',
        'research_place_date',
        'research_literature_review',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
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

        if ($this) {
            // Delete associated folder
            $studentNumber = $this->student_no;
            $directory = "public/forms/{$studentNumber}";

            // Ensure the directory exists before attempting to delete
            if (Storage::exists($directory)) {
                Storage::deleteDirectory($directory);
            }
        }
    }
}
