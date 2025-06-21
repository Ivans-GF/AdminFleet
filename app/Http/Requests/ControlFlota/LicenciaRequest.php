<?php

namespace App\Http\Requests\ControlFlota;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LicenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idoperador' => ['required', 'integer', 'exists:operadores,id'],
            'licencia' => ['required', 'file', 'mimes:pdf', 'max:10240'], // archivos: PDF, Word, Excel, máx 10MB
            'categorias' => ['required', 'array', 'min:1', 'in:A,B,C,E'], // 'categorias' must be an array, and have at least one item
            'vigencia' => ['required', 'date'], // Debe ser una fecha válida y no anterior a hoy
        ];
    }

    public function messages(): array
    {
        return [
            'idoperador.required' => 'El ID del operador es obligatorio.',
            'idoperador.integer' => 'El ID del operador debe ser un número entero.',
            'idoperador.exists' => 'El ID del operador no existe en nuestros registros.',

            'licencia.required' => 'Debes seleccionar un archivo.',
            'licencia.file' => 'El campo archivo debe ser un archivo válido.',
            'licencia.mimes' => 'El archivo debe ser de tipo: PDF',
            'licencia.max' => 'El tamaño máximo del archivo es 10 MB.',

            'categorias.required' => 'Las categorías son obligatorias.',
            'categorias.string' => 'Las categorías deben ser texto.',

            'vigencia.required' => 'La fecha de vigencia es obligatoria.',
            'vigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
        ];
    }
}
