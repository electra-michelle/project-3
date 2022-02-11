<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mailer = 'support';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $message, public $data){
        $this->onQueue('high');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admin.emails.support')
            ->from(config('mail.support_from.address'), config('mail.support_from.name'))
            ->subject($this->data['subject']);
    }
}
