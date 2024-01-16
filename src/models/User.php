<?php

namespace App\models;

use App\auth\Authenticable;
use App\dio\UserDio;

final class User
{

    use UserDio, Authenticable;

    public ?int $id;
    public ?string $first_name;
    public ?string $last_name;
    public ?string $email;
    public ?string $mobile = null;
    public ?string $password;
    public string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;
    public bool $is_admin;

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
