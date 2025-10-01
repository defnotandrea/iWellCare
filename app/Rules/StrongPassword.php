<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check minimum length
        if (strlen($value) < 10) {
            return false;
        }

        // Check for uppercase letter
        if (! preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Check for lowercase letter
        if (! preg_match('/[a-z]/', $value)) {
            return false;
        }

        // Check for number
        if (! preg_match('/\d/', $value)) {
            return false;
        }

        // Check for special character
        if (! preg_match('/[@$!%*?&]/', $value)) {
            return false;
        }

        // Check for consecutive identical characters (max 2)
        if (preg_match('/(.)\1{2,}/', $value)) {
            return false;
        }

        // Check for common patterns
        if (preg_match('/^(123|abc|qwe|asd|password|123456|qwerty)/i', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be at least 10 characters long and contain at least one uppercase letter, one lowercase letter, one number, one special character (@$!%*?&), and cannot contain common patterns or more than 2 consecutive identical characters.';
    }
}
