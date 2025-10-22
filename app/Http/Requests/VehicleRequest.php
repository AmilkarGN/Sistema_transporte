<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Asegúrate de que esto devuelva true o la lógica de autorización correcta
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'license_plate' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            // Modificadas para aceptar los valores del selector
            'load_capacity' => 'required|string|in:1-5,5-10,10-20,20-40,40+', // Ajusta si usas otros rangos
            'load_volume' => 'required|string|in:10-30,30-60,60-100,100+', // Ajusta si usas otros rangos
            'type' => 'required|string|max:255', // Asumiendo que 'type' también usa strings
            'status' => 'required|string|in:Available,In Maintenance,On Trip,Out of Service', // Ajusta si usas otros estados
            // 'driver_id' => 'nullable|exists:drivers,id', // Eliminar o comentar si ya no está en la tabla vehicles
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            // Modificada para aceptar los valores del selector 'Yes'/'No'
            'active_insurance' => 'required|string|in:Yes,No',
            'insurance_policy' => 'nullable|string|max:255',
            'average_speed' => 'nullable|numeric|min:0|max:200',
            'historical_performance' => 'nullable|string|max:255',
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
            'load_capacity.in' => 'El campo Capacidad de Carga debe ser uno de los valores aproximados permitidos.',
            'load_volume.in' => 'El campo Volumen de Carga debe ser uno de los valores aproximados permitidos.',
            'active_insurance.in' => 'El campo Seguro Activo debe ser "Sí" o "No".',
            // Puedes añadir mensajes personalizados para otras reglas si lo deseas
        ];
    }
}
