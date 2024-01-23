<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\LOG;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    private function sendEmail($emailsx, $subjectx, $messagex)
    {
        try {
            $emailArray = explode(',', $emailsx);

            foreach ($emailArray as $email) {
                Mail::send('emails.generic', ['emailMessage' => $messagex], function ($msg) use ($email, $subjectx) {
                    $msg->to($email)
                        ->subject($subjectx);
                });
            }
        } catch (Exception $e) {
            Log::error('Mail hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }

    public function handleSendEmail(Request $request)
    {
        try {
            if (Auth::user()->isMemberEtikKurul()) {
                $emails = $request->input('emails'); // array of email addresses
                $subject = $request->input('subject');
                $message = $request->input('message');
                $this->sendEmail($emails, $subject, $message);
            }
        } catch (Exception $e) {
            Log::error('Mail hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }
}
