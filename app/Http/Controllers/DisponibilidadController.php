<?php

namespace App\Http\Controllers;

use App\Services\DisponibilidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DisponibilidadController extends Controller
{
    protected DisponibilidadService $disponibilidad;

    public function __construct(DisponibilidadService $disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;
    }

    public function check(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'horas' => 'required|integer|min:1',
            'maquina_id' => 'nullable|exists:maquinas,id',
        ]);

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
