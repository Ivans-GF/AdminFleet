<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Francerz\MX_CURP\CURP;
class CurpValida implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $curp = new CURP($value);
            if (!$curp->esValida()) {
                $fail('El CURP no es válido.');
            }
        } catch (\Exception $e) {
            $fail('El formato del CURP no es correcto.');
        }
    }
}