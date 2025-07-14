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
            'operador_id' => ['required', 'integer', 'exists:operadores,id'],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:10240'], // archivos: PDF, Word, Excel, máx 10MB
            'categoria' => ['required', 'in:B,E,BE'],
            'fechavigencia' => [
                'required',
                'date',
                // Rule to check for unique combination of idoperador and fechavigencia
                Rule::unique('licencias')->where(function ($query) {
                    return $query->where('operador_id', $this->operador_id)
                                 ->where('fechavigencia', $this->fechavigencia);
                })
                // If you are also using this form for editing and need to ignore the current record:
                // ->ignore($this->licencia?->id, 'id') // Assuming 'licencia' is the route model binding for an existing license
            ],
            'comentario' => ['nullable', 'string', 'max:450'],
        ];
    }

    public function messages(): array
    {
        return [
            'operador_id.required' => 'El ID del operador es obligatorio.',
            'operador_id.integer' => 'El ID del operador debe ser un número entero.',
            'operador_id.exists' => 'El ID del operador no existe en nuestros registros.',

            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El campo archivo debe ser un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: PDF',
            'archivo.max' => 'El tamaño máximo del archivo es 10 MB.',

            'categoria.required' => 'La Categoría son obligatorias.',
            'categoria.string' => 'La Categoría deben ser texto.',
            'categoria.in' => 'Opción no valida.',

            'fechavigencia.required' => 'La fecha de vigencia es obligatoria.',
            'fechavigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
            'fechavigencia.unique' => 'Ya existe una licencia con la misma fecha de vigencia.',

            'comentario.max' => 'El Comentario solo admite 450 caracteres.',

        ];
    }
}
