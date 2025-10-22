<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importar Rule

class ShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Asegúrate de que esto retorne true si el usuario está autorizado
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Define las mismas opciones que en tu form.blade.php
        $shipmentTypes = ['General Cargo', 'Bulk Cargo', 'Dangerous Goods', 'Heavy Machinery', 'Vehicles', 'Container', 'Other'];
        $shipmentStatuses = ['Pending', 'Processing', 'In Transit', 'Delivered', 'Cancelled'];
        $shipmentPriorities = ['Low', 'Medium', 'High', 'Urgent'];

        return [
            'client_id' => 'required|exists:clients,id', // Asumiendo que tienes una tabla 'clients'
            'type' => ['required', 'string', Rule::in($shipmentTypes)], // Validar que el tipo esté en las nuevas opciones
            'weight_kg' => 'nullable|numeric|min:0', // Validar como numérico, permitir nulo, mínimo 0
            'volume_m3' => 'nullable|numeric|min:0', // Validar como numérico, permitir nulo, mínimo 0
            'description' => 'nullable|string|max:500',
            'request_date' => 'nullable|date', // Validar como fecha, permitir nulo
            'required_date' => 'nullable|date', // Validar como fecha, permitir nulo
            'status' => ['required', 'string', Rule::in($shipmentStatuses)], // Validar que el estado esté en las opciones
            'origin' => 'required|string|max:100',
            'origin_lat' => 'nullable|numeric', // Validar latitud (puede ser nulo si no se usa el mapa)
            'origin_lng' => 'nullable|numeric', // Validar longitud (puede ser nulo si no se usa el mapa)
            'destination' => 'required|string|max:100',
            'destination_lat' => 'nullable|numeric', // Validar latitud (puede ser nulo)
            'destination_lng' => 'nullable|numeric', // Validar longitud (puede ser nulo)
            'estimated_delivery_date' => 'nullable|date', // Validar como fecha, permitir nulo
            'actual_delivery_date' => 'nullable|date', // Validar como fecha, permitir nulo
            'priority' => ['nullable', 'string', Rule::in($shipmentPriorities)], // Validar que la prioridad esté en las opciones (nullable si no es obligatorio)
            'special_instructions' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.exists' => 'El cliente seleccionado no es válido.',
            'type.required' => 'El tipo de carga es obligatorio.', // Mensaje actualizado
            'type.in' => 'El tipo de carga seleccionado no es válido.', // Mensaje actualizado
            'weight_kg.numeric' => 'El peso debe ser un número válido.', // Mensaje mejorado
            'weight_kg.min' => 'El peso no puede ser negativo.',
            'volume_m3.numeric' => 'El volumen debe ser un número válido.', // Mensaje mejorado
            'volume_m3.min' => 'El volumen no puede ser negativo.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
            'request_date.date' => 'La fecha de solicitud debe ser una fecha válida.',
            'required_date.date' => 'La fecha requerida debe ser una fecha válida.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'origin.required' => 'El origen es obligatorio.',
            'destination.required' => 'El destino es obligatorio.',
            'origin_lat.numeric' => 'La latitud de origen debe ser un número.',
            'origin_lng.numeric' => 'La longitud de origen debe ser un número.',
            'destination_lat.numeric' => 'La latitud de destino debe ser un número.',
            'destination_lng.numeric' => 'La longitud de destino debe ser un número.',
            'estimated_delivery_date.date' => 'La fecha estimada de entrega debe ser una fecha válida.',
            'actual_delivery_date.date' => 'La fecha real de entrega debe ser una fecha válida.',
            'priority.in' => 'La prioridad seleccionada no es válida.',
            'special_instructions.max' => 'Las instrucciones especiales no pueden exceder los 500 caracteres.',
        ];
    }
}
