<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Voto;

class ComprobanteVotoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voto;

    public function __construct(Voto $voto)
    {
        $this->voto = $voto;
    }

    public function build()
    {
        return $this->subject('Tu Comprobante de Voto')
                    ->view('emails.comprobante');
    }
}
