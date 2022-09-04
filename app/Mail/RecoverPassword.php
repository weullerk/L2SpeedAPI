<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $login;
    public $logoSrc;
    public $url;
    public $serverName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $login, string $url)
    {
        $this->login = $login;
        $this->logoSrc = config('web.logo');
        $this->url = config('web.site') . config('web.reset_password_endpoint') . $url;
        $this->serverName = config('app.name');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('app.name'))
            ->view('emails.recover-password');
    }
}
