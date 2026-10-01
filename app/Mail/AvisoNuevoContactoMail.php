<?php

namespace App\Mail;

use App\Models\Ajuste;
use App\Models\Mensaje;
use App\Models\Presupuesto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoNuevoContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Mensaje $mensaje,
        public ?Presupuesto $presupuesto = null
    ) {}

    public function build(): self
    {
        $mail = $this->subject('⚡ Nueva solicitud de presupuesto - Magic360')
            ->view('correo.contacto_negocio', [
                'mensaje' => $this->mensaje,
                'presupuesto' => $this->presupuesto,
            ]);

        if ($this->presupuesto) {
            $ajuste = Ajuste::first();
            $pdf = Pdf::loadView('presupuesto.pdf', [
                'presupuesto' => $this->presupuesto,
                'ajuste' => $ajuste,
            ]);

            $mail->attachData($pdf->output(), "Presupuesto-{$this->presupuesto->numero}.pdf", [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
