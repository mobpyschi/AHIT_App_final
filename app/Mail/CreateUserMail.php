<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateUserMail extends Mailable
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
    public function build(Request $request)
    {
        return $this->from('hr@ahitcorp.net','HR AHIT')
        ->subject('Create AHIT accout')
        ->markdown('emails.newuser')
        ->with([
            'name'=>$request->name,
            'link'=>'https://ahitcorp.net/',
            'pass'=>$request->password,
            'username'=>$request->email
        ]);
    }
}
