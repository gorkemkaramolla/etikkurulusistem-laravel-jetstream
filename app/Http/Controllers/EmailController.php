<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    private function sendEmail($emailsx, $subjectx, $messagex)
    {
        $emailArray = explode(',', $emailsx);

        foreach ($emailArray as $email) {
            Mail::send('emails.generic', ['emailMessage' => $messagex], function ($msg) use ($email, $subjectx) {
                $msg->to($email)
                    ->subject($subjectx);
            });
        }
    }

    public function handleSendEmail(Request $request)
    {
        if (Auth::user()->isMemberEtikKurul()) {
            $emails = $request->input('emails'); // array of email addresses
            $subject = $request->input('subject');
            $message = $request->input('message');
            $this->sendEmail($emails, $subject, $message);
        }
    }
}
