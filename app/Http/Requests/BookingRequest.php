<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Aquí puedes agregar lógica para autorizar la solicitud si es necesario.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'route_id' => 'nullable|integer|exists:routes,id',
            'request_date' => 'required|date',
            'estimated_trip_date' => 'nullable|date',
            'status' => 'required|string|max:50', // Mantener como string, aunque es ENUM, 'in' es más específico
            'estimated_shipment_type' => 'nullable|string|max:100', // Mantener como string, aunque es ENUM, 'in' es más específico
            'estimated_weight' => 'nullable|numeric|min:0',
            'estimated_volume' => 'nullable|numeric|min:0',
            // Modificada la regla de validación para aceptar los valores del ENUM
            'priority' => 'nullable|in:low,normal,high',
            'notes' => 'nullable|string|max:255',
            'assigned_trip_id' => 'nullable|integer|exists:trips,id',
        ];
    }
}
