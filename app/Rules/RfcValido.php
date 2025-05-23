<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Francerz\MX_RFC\RFC; // Correctly imported
use Illuminate\Support\Facades\Lang;
class RfcValido implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $rfc = new RFC($value);
            if (!$rfc->esValido()) {
                $fail(Lang::get('El RFC no es válido.'));
            }
        } catch (\Exception $e) {
            $fail(Lang::get('El formato del RFC no es correcto.'));
        }
    }
}
