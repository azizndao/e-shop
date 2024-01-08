<?php

namespace App\dio;

use App\models\Category;
use App\utils\DB;
use DateTime;

trait CategoryDio
{

    public function save(): Category
    {
        $statement = DB::getPDO()->prepare(
            "INSERT INTO categories (name, image, created_by) VALUES (:name, :image_url, :created_by)"
        );
        $statement->execute([
            'name' => $this->name,
            'image_url' => $this->image_url,
            'created_by' => $this->created_by
        ]);
        $statement = DB::getPDO()->prepare("SELECT * FROM categories WHERE id = ?");
        $statement->execute([$this->getPDO()->lastInsertId()]);
        return $statement->fetchObject(Category::class);
    }


    public function update(): Category
    {
        $this->updated_at = new DateTime();
        $statement = DB::getPDO()->prepare(
            "UPDATE categories SET name = :name, image = :image_url, updated_at = :updated_at WHERE id = :id"
        );
        $statement->execute([
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'updated_at' => $this->updated_at
        ]);
        return $this;
    }

    public function delete(): void
    {
        $statement = DB::getPDO()->prepare("DELETE FROM categories WHERE id = ?");
        $statement->execute([$this->id]);
    }

    /**
     * @return Category[]
     */
    public static function getAll(): array
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM categories");
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS, Category::class);
    }

    public static function getById(int $id): Category
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM categories WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetchObject(Category::class);
    }
}