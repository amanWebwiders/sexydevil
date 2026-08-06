<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectbyAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userDetails;

    public function __construct($userDetails)
    {
        $this->userDetails = $userDetails;
       
    }

    public function build()
    {
        
        return $this->subject('Your Profile Rejected by Admin') // Set the subject here
                    ->view('email.reject')
                    ->with([
                        'userDetails' => $this->userDetails,
                    ]);
    }
}
