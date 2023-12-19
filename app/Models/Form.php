<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
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
}
