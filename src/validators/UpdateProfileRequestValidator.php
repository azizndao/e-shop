<?php

namespace App\validators;

use App\models\User;

/**
 * This class is used to validate the registration request
 */
class UpdateProfileRequestValidator extends RequestValidator
{

    public function validate(): void
    {
        $cdt = $this->credentials;
        if (empty($cdt['first_name'])) {
            $this->setError('first_name', '* Requise');
        } else {
            $this->setValidated('first_name', $cdt['first_name']);
        }

        if (empty($cdt['last_name'])) {
            $this->setError('last_name', '* Requise');
        } else {
            $this->setValidated('last_name', $cdt['last_name']);
        }

        if (empty($cdt['email'])) {
            $this->setError('email', '* Requise');
        } else if (User::getByEmail($cdt['email'] ?? "") !== null) {
            $this->setError('email', 'Email already registered');
        } else {
            $this->setValidated('email', $cdt['email']);
        }

        if (empty($cdt['mobile'])) {
            $this->setError('mobile', '* Requise');
        } else {
            $this->setValidated('mobile', $cdt['mobile']);
        }
    }
}
