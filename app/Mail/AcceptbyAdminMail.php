<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptbyAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userDetails;

    public function __construct($userDetails)
    {
        $this->userDetails = $userDetails;
    }

    public function build()
    {
        return $this->subject('Your Account Request Accepted by Admin')->view('email.accept')
            ->with(['userDetails' => $this->userDetails]);
    }
}
