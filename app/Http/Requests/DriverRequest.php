<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            
            'user_id' => 'required|integer|exists:users,id', // Debe existir en la tabla users.
            'license_number' => 'required|string|max:50|unique:drivers,license_number', // Único en la tabla drivers.
            'license_expiration' => 'nullable|date|after:today', // Asegúrate de que sea una fecha válida.
            'license_type' => 'required|string|max:20', // Tipo de licencia obligatorio.
            'status' => 'required|string|max:50', // Estado del conductor.
            'monthly_driving_hours' => 'nullable|numeric|min:0', // Horas de conducción mensuales opcionales.
            'safety_score' => 'nullable|numeric|min:0|max:100', // Puntaje de seguridad entre 0 y 100.
            'last_evaluation' => 'nullable|date', // Fecha de la última evaluación opcional.
        ];
    }
}