<?php

namespace App\Http\Requests\ControlFlota;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CurpValida;
use App\Rules\RfcValido;
use App\Rules\ImssValido;

class UpdateOperadoresRequest extends FormRequest
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
        $operatorId = $this->route('operador');

        return [
            'curp' => ['required', 'string', 'max:18', new CurpValida(),  Rule::unique('operadores', 'curp')->ignore($operatorId)],
            'rfc' => ['required', 'string', 'min:12', 'max:13', new RfcValido(),  Rule::unique('operadores', 'rfc')->ignore($operatorId)],
            'nss' => ['required', 'numeric', 'digits:11', new ImssValido(),  Rule::unique('operadores', 'nss')->ignore($operatorId)],
            'nolicencia' => ['required', 'string', 'max:20',  Rule::unique('operadores', 'nolicencia')->ignore($operatorId)],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => [
                'required',
                'string',
                'max:255',
                Rule::unique('operadores')->where(function ($query) {
                    $query->where('nombre', $this->nombre)
                        ->where('apellido', $this->apellido);
                })->ignore($operatorId)
            ],
            'telefono' => ['required', 'string', 'max:20',  Rule::unique('operadores', 'telefono')->ignore($operatorId)],
            'domicilio' => ['nullable', 'string', 'max:240'],
            'nota' => ['nullable', 'string', 'max:650'],
        ];
    }

    public function messages(): array
    {
        return [
            'curp.required' => 'El CURP es obligatorio.',
            'curp.unique' => 'Ya existe un operador con el CURP.',
            'curp.min' => 'El CURP requiere 18 caracteres.',
            'curp.max' => 'El CURP solo admite 18 caracteres.',

            'rfc.required' => 'El RFC es obligatorio.',
            'rfc.unique' => 'Ya existe un operador con el RFC.',
            'rfc.min' => 'El RFC requiere 12 caracteres.',
            'rfc.max' => 'El RFC solo admite 13 caracteres.',

            'nss.required' => 'El NSS es obligatorio.',
            'nss.unique' => 'Ya existe un operador con el NSS.',
            'nss.digits' => 'El RFC requiere 11 caracteres.',

            'nolicencia.required' => 'La Licencia es obligatorio.',
            'nolicencia.unique' => 'Ya existe un operador con esta licencia.',
            'nolicencia.max' => 'La Licencia admite 20 caracteres.',

            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.max' => 'El Nombre solo admite 255 caracteres.',

            'apellido.required' => 'El Apellido es obligatorio.',
            'apellido.max' => 'El Apellido solo admite 255 caracteres.',
            'apellido.unique' => 'Ya existe un operador con el mismo nombre y apellido.',

            'telefono.required' => 'El Teléfono es obligatorio.',
            'telefono.unique' => 'Ya existe un operador con el Teléfono.',
            'telefono.max' => 'El Teléfono solo admite 20 caracteres.',

            'domicilio.max' => 'El Domicilio solo admite 240 caracteres.',
            'nota.max' => 'El Domicilio solo admite 650 caracteres.',
        ];
    }
}
