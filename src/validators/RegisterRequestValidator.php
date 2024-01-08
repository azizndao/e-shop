<?php

namespace App\validators;

use App\models\User;

/**
 * This class is used to validate the registration request
 */
class RegisterRequestValidator extends RequestValidator
{

    public function validate(): void
    {
        $cdt = $this->credentials;
        if (empty($cdt['first_name'])) {
            $this->setError('first_name', '* Required');
        } else {
            $this->setValidated('first_name', $cdt['first_name']);
        }

        if (empty($cdt['last_name'])) {
            $this->setError('last_name', '* Required');
        } else {
            $this->setValidated('last_name', $cdt['last_name']);
        }

        if (empty($cdt['email'])) {
            $this->setError('email', '* Required');
        } else if (User::getByEmail($cdt['email'] ?? "") !== null) {
            $this->setError('email', 'Email already registered');
        } else {
            $this->setValidated('email', $cdt['email']);
        }

        if (empty($cdt['mobile'])) {
            $this->setError('mobile', '* Required');
        } else {
            $this->setValidated('mobile', $cdt['mobile']);
        }

        if (empty($cdt['password'])) {
            $this->setError('password', '* Required');
        } else if (strlen($cdt['password']) < 8) {
            $this->setError('password', 'Enter a strong password');
        } else {
            $this->setValidated('password', $cdt['password']);
        }

        if (empty($cdt['password-confirmation'])) {
            $this->setError('password-confirmation', '* Required');
        } else if ($cdt['password'] !== $cdt['password-confirmation']) {
            $this->setError('password-confirmation', 'Enter the same password');
        } else {
            $this->setValidated('password-confirmation', $cdt['password-confirmation']);
        }
    }
}