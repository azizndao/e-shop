<?php

namespace App\validators;

class UpdatePasswordRequestValidator extends RequestValidator
{

    public function validate(): void
    {
        $cdt = $this->credentials;
        if (empty($cdt['password'])) {
            $this->setError('password', '* Requise');
        } else if (strlen($cdt['password']) < 8) {
            $this->setError('password', 'Enter a strong password');
        } else {
            $this->setValidated('password', $cdt['password']);
        }

        if (empty($cdt['new-password'])) {
            $this->setError('new-password', '* Requise');
        } else if (strlen($cdt['new-password']) < 8) {
            $this->setError('new-password', 'Le mot de passe doit ');
        } else {
            $this->setValidated('new-password', $cdt['new-password']);
        }

        if (empty($cdt['password-confirmation'])) {
            $this->setError('password-confirmation', '* Requise');
        } else if ($cdt['new-password'] !== $cdt['password-confirmation']) {
            $this->setError('password-confirmation', 'Les mots de passe ne sont identiques');
        } else {
            $this->setValidated('password-confirmation', $cdt['password-confirmation']);
        }
    }
}
