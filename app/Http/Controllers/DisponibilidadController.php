<?php

namespace App\Http\Controllers;

use App\Services\DisponibilidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DisponibilidadController extends Controller
{
    protected DisponibilidadService $disponibilidad;

    public function __construct(DisponibilidadService $disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;
    }

    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'horas' => 'required|integer|min:1',
            'maquina_id' => 'nullable|exists:maquinas,id',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora debe tener el formato HH:MM.',
            'horas.required' => 'Las horas de duración son obligatorias.',
            'horas.integer' => 'Las horas deben ser un número entero.',
            'horas.min' => 'El mínimo de horas es 1.',
            'maquina_id.exists' => 'La máquina seleccionada no existe.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'mensajes' => $validator->errors()
            ], 422);
        }

        $fecha = Carbon::parse($request->fecha, 'Europe/Madrid');
        $horaInicio = $request->hora_inicio;
        $horas = $request->horas;
        $maquinaId = $request->maquina_id;

        $libre = $this->disponibilidad->estaLibre($fecha, $horaInicio, $horas, $maquinaId);

        if ($libre) {
            return response()->json(['libre' => true, 'alternativas' => []]);
        }

        $alternativas = $this->disponibilidad->alternativas($fecha, $horas, $maquinaId);
        
        return response()->json([
            'libre' => false,
            'alternativas' => $alternativas
        ]);
    }
}
