<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Francerz\MxImss\NumeroSeguro;
use Illuminate\Support\Facades\Lang;
class ImssValido implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nss = new NumeroSeguro($value);
        try {
            if (!$nss->esValido()) {
                $fail(Lang::get('El NSS no es válido.'));
            }
        } catch (\Exception $e) {
            $fail(Lang::get('El formato del NSS no es correcto.'));
        }
    }  
    
}
