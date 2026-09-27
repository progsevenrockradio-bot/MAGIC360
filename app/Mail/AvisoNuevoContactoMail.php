<?php

namespace App\Mail;

use App\Models\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoNuevoContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mensaje $mensaje) {}

    public function build(): self
    {
        return $this->subject('⚡ Nueva solicitud de presupuesto - Magic360')
            ->view('correo.contacto_negocio');
    }
}
