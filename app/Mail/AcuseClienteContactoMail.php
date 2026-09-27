<?php

namespace App\Mail;

use App\Models\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcuseClienteContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mensaje $mensaje) {}

    public function build(): self
    {
        return $this->subject('Hemos recibido tu solicitud · Magic360')
            ->view('correo.contacto_cliente');
    }
}
