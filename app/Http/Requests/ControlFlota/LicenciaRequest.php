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
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:10240'], // archivos: PDF, Word, Excel, máx 10MB
            'nolicencia' => ['required', 'string', 'min:5', 'max:15'],
            'categoria' => ['required', 'in:B,E,BE'],
            'fechavigencia' => ['required', 'date'],
            'comentario' => ['nullable', 'string', 'max:450'],
        ];
    }

    public function messages(): array
    {
        return [
            'idoperador.required' => 'El ID del operador es obligatorio.',
            'idoperador.integer' => 'El ID del operador debe ser un número entero.',
            'idoperador.exists' => 'El ID del operador no existe en nuestros registros.',

            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El campo archivo debe ser un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: PDF',
            'archivo.max' => 'El tamaño máximo del archivo es 10 MB.',

            'nolicencia.required' => 'El No. de licencia es obligatorio.',
            'nolicencia.min' => 'El No. de licencia requiere 5 caracteres.',
            'nolicencia.max' => 'El No. de licencia solo admite 15 caracteres.',

            'categoria.required' => 'La Categoría son obligatorias.',
            'categoria.string' => 'La Categoría deben ser texto.',
            'categoria.in' => 'Opción no valida.',

            'fechavigencia.required' => 'La fecha de vigencia es obligatoria.',
            'fechavigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',

            'comentario.max' => 'El Comentario solo admite 450 caracteres.',

        ];
    }
}
