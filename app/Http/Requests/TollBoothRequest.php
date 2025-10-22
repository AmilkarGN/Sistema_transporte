<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TollBoothRequest extends FormRequest
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
            'name' => 'required|string|max:100', // Nombre obligatorio, máximo 100 caracteres.
            'location' => 'required|string|max:255', // Ubicación obligatoria, máximo 255 caracteres.
            'route_id' => 'required|integer|exists:routes,id', // Debe existir en la tabla routes.
            'heavy_vehicle_cost' => 'required|numeric|min:0', // Costo para vehículos pesados obligatorio.
            'operation_hours' => 'nullable|string|max:50', // Horas de operación opcionales, máximo 50 caracteres.
            'latitude' => 'nullable|numeric|between:-90,90', // Latitud opcional, debe estar entre -90 y 90.
            'longitude' => 'nullable|numeric|between:-180,180', // Longitud opcional, debe estar entre -180 y 180.
        ];
    }
}