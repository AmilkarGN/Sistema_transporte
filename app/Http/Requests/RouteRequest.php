<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Asegúrate de que esto retorne true si el usuario está autorizado
        // o implementa la lógica de autorización necesaria.
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
            'name' => 'required|string|max:100',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'origen_lat' => 'nullable|numeric', // Permitir nulo
            'origen_lng' => 'nullable|numeric', // Permitir nulo
            'destino_lat' => 'nullable|numeric', // Permitir nulo
            'destino_lng' => 'nullable|numeric', // Permitir nulo
            'distance_km' => 'nullable|numeric|min:0', // Cambiado a nullable
            'estimated_time_hours' => 'nullable|numeric|min:0', // Cambiado a nullable
            'toll_booths' => 'nullable|integer|min:0', // Permitir nulo, si tiene valor, debe ser entero >= 0
            'estimated_toll_cost' => 'nullable|numeric|min:0', // Permitir nulo, si tiene valor, debe ser numérico >= 0
            'status' => 'required|string|in:Active,Inactive,Under Maintenance,Closed', // Asegúrate de que coincida con la migración
            'difficulty' => 'nullable|string|in:low,medium,high', // Permitir nulo, si tiene valor, debe ser uno de estos
            'details' => 'nullable|string|max:500', // Permitir nulo
            'risk_points' => 'nullable|integer|min:0|max:5', // Permitir nulo, si tiene valor, debe ser entero entre 0 y 5
            'last_update' => 'nullable|date', // Permitir nulo, si tiene valor, debe ser una fecha
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
            'name.required' => 'El nombre de la ruta es obligatorio.',
            'origin.required' => 'El origen de la ruta es obligatorio.',
            'destination.required' => 'El destino de la ruta es obligatorio.',
            'distance_km.numeric' => 'La distancia debe ser un número.',
            'distance_km.min' => 'La distancia no puede ser negativa.',
            'estimated_time_hours.numeric' => 'El tiempo estimado debe ser un número.',
            'estimated_time_hours.min' => 'El tiempo estimado no puede ser negativo.',
            'toll_booths.integer' => 'Las casetas de peaje deben ser un número entero.',
            'toll_booths.min' => 'Las casetas de peaje no pueden ser negativas.',
            'estimated_toll_cost.numeric' => 'El costo estimado de peaje debe ser un número.',
            'estimated_toll_cost.min' => 'El costo estimado de peaje no puede ser negativo.',
            'status.required' => 'El estado de la ruta es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'difficulty.in' => 'La dificultad seleccionada no es válida.',
            'details.max' => 'Los detalles no pueden exceder los 500 caracteres.',
            'risk_points.integer' => 'Los puntos de riesgo deben ser un número entero.',
            'risk_points.min' => 'Los puntos de riesgo no pueden ser menores a 0.',
            'risk_points.max' => 'Los puntos de riesgo no pueden ser mayores a 5.',
            'last_update.date' => 'La última actualización debe ser una fecha válida.',
        ];
    }
}
