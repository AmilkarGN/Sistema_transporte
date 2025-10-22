<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importar Rule

class ShipmentAssignmentRequest extends FormRequest
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
        // Define las opciones válidas para el estado de la asignación
        // AJUSTADO: Coincide con los valores del ENUM en la base de datos
        $assignmentStatuses = ['loaded', 'in_transit', 'delivered', 'problem'];

        return [
            'shipment_id' => 'required|exists:shipments,id', // Debe existir en la tabla shipments
            'driver_id' => 'required|exists:drivers,id',     // Debe existir en la tabla drivers
            'vehicle_id' => 'required|exists:vehicles,id',   // Debe existir en la tabla vehicles
            'route_id' => 'required|exists:routes,id',       // Debe existir en la tabla routes
            'assignment_date' => 'required|date',            // Fecha de asignación (obligatoria y formato fecha)
            // Eliminados campos de hora: scheduled_pickup_time, scheduled_delivery_time, actual_pickup_time, actual_delivery_time
            'status' => ['required', 'string', Rule::in($assignmentStatuses)], // Estado (obligatorio, string, en la lista)
            'notes' => 'nullable|string|max:500',            // Notas (opcional, string, max 500 caracteres)
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
            'shipment_id.required' => 'El envío es obligatorio.',
            'shipment_id.exists' => 'El envío seleccionado no es válido.',
            'driver_id.required' => 'El conductor es obligatorio.',
            'driver_id.exists' => 'El conductor seleccionado no es válido.',
            'vehicle_id.required' => 'El vehículo es obligatorio.',
            'vehicle_id.exists' => 'El vehículo seleccionado no es válido.',
            'route_id.required' => 'La ruta es obligatoria.',
            'route_id.exists' => 'La ruta seleccionada no es válida.',
            'assignment_date.required' => 'La fecha de asignación es obligatoria.',
            'assignment_date.date' => 'La fecha de asignación debe ser una fecha válida.',
            // Eliminados mensajes de error para campos de hora
            'status.required' => 'El estado de la asignación es obligatorio.',
            // Mensaje de error ajustado para reflejar los valores válidos
            'status.in' => 'El estado de la asignación seleccionado no es válido. Los estados permitidos son: Cargado, En Tránsito, Entregada, Problema.',
            'notes.max' => 'Las notas no pueden exceder los 500 caracteres.',
        ];
    }
}
