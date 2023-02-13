<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Helpcenter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postpayload)
    {
        $this->postpayload = $postpayload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->postpayload);
        return $this->from('dhyeyrathod111@gmail.com',env('ADMIN_EMAIL_NAME'))->subject("Help center")->view('email.admin_helpcenter',$this->postpayload);
    }
}
