<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentUserPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Auth::guard('web')->check()) {
            return;
        }


        $user = Auth::guard('web')->user();


        if (!$user) {
            return;
        }


        if (!Hash::check($value, $user->password)) {
            $fail('The current password is incorrect.');
        }
    }
}
