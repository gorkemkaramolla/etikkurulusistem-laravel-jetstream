<?php


namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\EtikKurulOnayi;
use App\Models\Form;

class UserInActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        if ($user->role === "etik_kurul") {

            EtikKurulOnayi::where("user_id", $user->id)->delete();
        }
    }
}
