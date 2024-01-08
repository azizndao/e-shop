<?php

namespace App\dio;

use App\models\User;
use App\utils\DB;
use PDO;

trait UserDio
{

    public static function fromArray(array $data): User
    {
        $user = new User();
        $user->id = $data["id"] ?? null;
        $user->first_name = $data["first_name"] ?? null;
        $user->last_name = $data["last_name"] ?? null;
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->is_admin = $data["is_admin"] ?? false;
        $user->created_at = $data["created_at"] ?? date('Y-m-d H:i:s');
        $user->updated_at = $data["updated_at"];
        return $user;
    }

    public function save(): User
    {
        if ($this->created_at == null) $this->created_at = date('Y-m-d H:i:s');

        $statement = DB::getPDO()->prepare(
            "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES (:first_name, :last_name, :email, :password, :created_at, :updated_at)"
        );

        $statement->execute([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $statement = DB::getPDo()->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $this->email]);
        return $statement->fetchObject(User::class);
    }

    public function update(): User
    {
        $this->updated_at = date('Y-m-d H:i:s');
        $statement = DB::getPDo()->prepare(
            "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, updated_at = :updated_at WHERE id = :id"
        );
        $statement->execute([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'updated_at' => $this->updated_at,
            'id' => $this->id
        ]);
        return $this;
    }

    public function updatePassword(string $currentPassword, $newPassword): User
    {
        if (password_verify($currentPassword, $this->password)) {
            $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
            $statement = DB::getPDo()->prepare(
                "UPDATE users SET password = :password, updated_at = :updated_at WHERE id = :id"
            );
            $statement->execute([
                'password' => password_hash($this->password, PASSWORD_DEFAULT),
                'updated_at' => $this->updated_at,
                'id' => $this->id
            ]);
        }
        return $this;
    }


    public function delete(): void
    {
        $statement = DB::getPDo()->prepare("DELETE FROM users WHERE id = :id");
        $statement->execute(['id' => $this->id]);
    }

    /**
     * @return User[]
     */
    public static function getAll(): array
    {
        $statement = DB::getPDo()->prepare("SELECT * FROM users");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public static function getById(int $id): ?User
    {
        $statement = DB::getPDo()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetchObject(User::class);
        return $result === false ? null : $result;
    }

    public static function getByEmail(string $email): ?User
    {
        $statement = DB::getPDo()->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $result = $statement->fetchObject(User::class);
        return $result === false ? null : $result;
    }
}