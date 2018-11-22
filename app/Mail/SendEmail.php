<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $demo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $importId = $this->demo->import_id;
        return $this->from('sender@example.com')
            ->view('mails.demo')
            ->subject("Email from MODULE-03")
            ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ])
            ->attach(public_path('/') . $importId . '.zip', [
                'as' => $importId . '.zip',
                'mime' => 'zip',
            ]);
    }
}
