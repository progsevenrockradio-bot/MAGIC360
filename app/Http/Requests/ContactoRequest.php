<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'fecha_evento' => ['nullable', 'date', 'after_or_equal:today'],
            'ciudad' => ['nullable', 'string', 'max:255'],
            'tipo_evento' => ['nullable', 'string', 'max:255'],
            'horas' => ['nullable', 'string', 'max:255'],
            'zona' => ['nullable', 'string', 'max:255'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
            'consentimiento' => ['required', 'accepted'],
            'web' => ['nullable', 'max:0'], // Honeypot field anti-spam
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Por favor, introduce tu nombre.',
            'telefono.required' => 'Es necesario un teléfono de contacto para llamarte o enviar WhatsApp.',
            'email.required' => 'Por favor, introduce tu dirección de correo electrónico.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'fecha_evento.after_or_equal' => 'La fecha del evento debe ser hoy o una fecha futura.',
            'consentimiento.accepted' => 'Debes aceptar la política de privacidad para enviar el formulario.',
        ];
    }
}
