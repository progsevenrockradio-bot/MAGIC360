<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoStoreRequest extends FormRequest
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
            'ciudad' => ['required', 'string', 'max:255'],
            'horas' => ['required'],
            'fecha_evento' => ['nullable', 'date'],
            'tipo_evento' => ['nullable', 'string', 'max:255'],
            'zona_id' => ['nullable'],
            'zona' => ['nullable', 'string', 'max:255'],
            'horas_extra_viaje' => ['nullable', 'integer', 'min:0'],
            'extras' => ['nullable', 'array'],
            'nocturnidad' => ['nullable'],
            'hora_fin' => ['nullable', 'string', 'max:10'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
            'consentimiento' => ['nullable'],
            'web' => ['nullable', 'max:0'], // Honeypot field
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Por favor, introduce tu nombre.',
            'telefono.required' => 'Introduce un número de teléfono de contacto.',
            'email.required' => 'Es necesario un email para enviarte el presupuesto.',
            'email.email' => 'El formato del email no es válido.',
            'ciudad.required' => 'Indica la ciudad o población donde se celebrará el evento.',
            'horas.required' => 'Selecciona las horas estimadas de servicio.',
        ];
    }
}
