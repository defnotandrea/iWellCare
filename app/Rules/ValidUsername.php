<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUsername implements Rule
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
        if (strlen($value) < 4) {
            return false;
        }

        // Check maximum length
        if (strlen($value) > 20) {
            return false;
        }

        // Check format (letters, numbers, and underscores only)
        if (! preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            return false;
        }

        // Check for reserved words
        $reservedWords = [
            'admin', 'root', 'administrator', 'system', 'user',
            'test', 'demo', 'guest', 'anonymous', 'null', 'undefined',
            'true', 'false', 'yes', 'no', 'on', 'off',
        ];

        if (in_array(strtolower($value), $reservedWords)) {
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
        return 'The :attribute must be 4-20 characters long, contain only letters, numbers, and underscores, and cannot be a reserved word.';
    }
}
