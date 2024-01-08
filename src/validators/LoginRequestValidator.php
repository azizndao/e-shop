<?php

namespace App\validators;

/**
 * This class is used to validate login credentials
 */
class LoginRequestValidator extends RequestValidator
{

    public function validate(): void
    {
        $email = $this->credentials['email'] ?? null;
        $password = $this->credentials['password'] ?? null;

        if (isset($email) && str_contains($email, '@') && isset($password)) return;

        $this->setError("error", "Invalid credentials");
    }
}