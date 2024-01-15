<?php


namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\EtikKurulOnayi;
use App\Models\Form;

class NewUserAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        if ($user->role === "etik_kurul") {
            $formsAtEtikKurul = Form::where("stage", "etik_kurul")->get();
            $formsAtEtikKurul->each(function ($form) use ($user) {
                EtikKurulOnayi::create([
                    "form_id" => $form->id,
                    "user_id" => $user->id,
                    "onay_durumu" => "bekleme",
                ]);
            });
        }
    }
}
