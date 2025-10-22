<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiar a true para permitir la autorización.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'route_id' => 'required|integer|exists:routes,id', // Debe existir en la tabla routes.
            'vehicle_id' => 'required|integer|exists:vehicles,id', // Debe existir en la tabla vehicles.
            'driver_id' => 'required|integer|exists:drivers,id', // Debe existir en la tabla drivers.
            'departure_date' => 'required|date', // Fecha de salida obligatoria.
            'estimated_arrival' => 'required|date|after:departure_date', // Fecha estimada de llegada obligatoria.
            'actual_arrival' => 'nullable|date|after_or_equal:departure_date', // Fecha real de llegada opcional.
            'status' => 'required|in:pendiente,asignado,en_progreso,finalizado',// Estado obligatorio (valores permitidos: pendiente, asignado, en_progreso, finalizado).
            'actual_total_cost' => 'nullable|numeric|min:0', // Costo total real opcional.
            'initial_mileage' => 'required|integer|min:0', // Kilometraje inicial obligatorio.
            'final_mileage' => 'nullable|integer|min:0|gte:initial_mileage', // Kilometraje final opcional, debe ser mayor o igual al inicial.
            'notes' => 'nullable|string', // Notas opcionales.
            'time_deviation' => 'nullable|numeric|min:0', // Desviación de tiempo opcional.
            'route_score' => 'nullable|integer|min:1|max:5', // Puntuación de la ruta opcional (1-5 estrellas).
            'delay_reason' => 'nullable|string', // Razón del retraso opcional.
            'problem_segment_id' => 'nullable|integer|exists:segments,id', // Segmento problemático opcional.
        ];
    }
}