<?php

namespace App\auth;

use App\models\User;
use App\validators\LoginRequestValidator;
use App\validators\RegisterRequestValidator;
use App\validators\UpdatePasswordRequestValidator;
use App\validators\UpdateProfileRequestValidator;

trait Authenticable
{

    /**
     * Validates user credentials and logs in the user.
     *
     * @param string[] $form The user's login credentials.
     * @return string[] Returns an array containing errors if the credentials are invalid, or an empty array if the login is successful.
     */
    public static function login(array $form): array
    {
        $validator = new LoginRequestValidator($form);

        if (!$validator->isValid()) {
            return $validator->getErrors();
        }

        $user = self::getByEmail($form['email']);
        if ($user != null && password_verify($form['password'], $user->password)) {
            $_SESSION['user'] = (array)$user;
            return [];
        }
        return ['error' => 'Invalid credentials'];
    }

    /**
     * Registers a user with the given credentials.
     *
     * @param string[] $credentials The user's registration credentials.
     * @return array An empty array.
     */
    public static function register(array $credentials): array
    {
        $validator = new RegisterRequestValidator($credentials);
        $validator->validate();
        if (!$validator->isValid())
            return $validator->getErrors();
        $user = User::fromArray($credentials);
        $user->save();
        self::login(['email' => $user->email, 'password' => $user->password]);
        return [];
    }

    public function tryUpdateProfile(array $credentials): array
    {

        $validator = new UpdateProfileRequestValidator($_POST);
        $validator->validate();
        if (!$validator->isValid()) {
            return $validator->getErrors();
        }
        $this->first_name = $credentials['first_name'];
        $this->last_name = $credentials['last_name'];
        $this->email = $credentials['email'];
        $this->mobile = $credentials['mobile'];

        $_SESSION['user'] = (array)$this->update();
        return [];
    }

    public function tryUpdatePassword(array $credentials): array
    {
        $validator = new UpdatePasswordRequestValidator($credentials);
        $validator->validate();

        if (!$validator->isValid()) {
            return $validator->getErrors();
        }

        $validated = $validator->getValidated();

        if (!password_verify($validated['password'], $this->password)) {
            return ['password' => 'Mot de passe invalide'];
        }

        $this->updatePassword(currentPassword: $this->password, newPassword: $validated['new-password']);

        return [];
    }

    /**
     * Logout the user by unsetting the 'user' session variable.
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * Retrieves the current user from the session.
     *
     * @return User|null The current user, or null if no user is found in the session.
     */
    public static function getCurrent(): ?User
    {
        return isset($_SESSION['user']) ? User::fromArray((array)$_SESSION['user']) : null;
    }

    /**
     * Checks if the user is logged in.
     *
     * @return bool Returns true if the user is logged in, false otherwise.
     */
    public static function isLogIn(): bool
    {
        return self::getCurrent() !== null;
    }

    public static function isAdmin(): bool
    {
        $user = self::getCurrent();
        return $user !== null && $user->is_admin;
    }
}
