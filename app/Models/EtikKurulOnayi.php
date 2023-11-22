<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Forms;


class EtikKurulOnayi extends Model
{
    protected $table = 'etik_kurul_onayi';

    protected $fillable = ['form_id', 'user_id', 'onay_durumu'];

    public function form()
    {
        return $this->belongsTo(Forms::class, 'form_id');
    }

    public function etikKurulUye()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}