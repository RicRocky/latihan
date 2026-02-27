<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GudangEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $isi;
    public $subjectEmail;

    public function __construct($subjectEmail, $isi)
    {
        $this->subjectEmail = $subjectEmail;
        $this->isi = $isi;
    }

    public function build()
    {
        return $this->subject($this->subjectEmail)
            ->view('email.gudang')
            ->with([
                'isi' => $this->isi,
                'subjectEmail' => $this->subjectEmail,
            ]);
    }
}
