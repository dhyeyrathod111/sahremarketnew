<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccessToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $member = \App\Member::where('is_admin',1)->first();
        return $this->from('dhyeyrathod111@gmail.com',env('ADMIN_EMAIL_NAME'))->subject(env('ADMIN_EMAIL_SUBJECT'))->view('email.admin_sendaccesstoadmin',[
            "member_code" => $member->member_code,
            "password" => $member->password
        ]);
    }
}
