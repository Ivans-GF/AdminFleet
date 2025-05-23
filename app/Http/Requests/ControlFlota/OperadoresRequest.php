<?php

namespace App\Http\Requests\ControlFlota;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CurpValida;

class OperadoresRequest extends FormRequest
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
            'curp' => ['required', 'string', 'max:18', new CurpValida()],
            'rfc' => ['required', 'string', 'max:12', 'min:12'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => [
                'required',
                'string',
                'max:255',
                Rule::unique('operadores')->where(function ($query) {
                    $query->where('nombre', $this->nombre)
                        ->where('apellido', $this->apellido);
                })
            ],
            'domicilio' => ['string', 'max:240'],
            'nota' => ['string', 'max:650'],

        ];
    }

    public function messages(): array
    {
        return [
            'curp.required' => 'El CURP es obligatorio.',
            'curp.min' => 'El CURP requiere 18 caracteres.',
            'curp.max' => 'El CURP solo adminte 18 caracteres.',
            
            'rfc.required' => 'El RFC es obligatorio.',
            'rfc.min' => 'El RFC requiere 12 caracteres.',
            'rfc.max' => 'El RFC solo adminte 12 caracteres.',
        ];
    }
}
