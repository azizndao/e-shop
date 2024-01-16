<?php

namespace App\dio;

use App\models\Category;
use App\utils\DB;

/**
 * Ici nous avons les methodes qui nous permettent d'ajouter, de modifier, de supprimer et de lister les marques
 */
trait CategoryDio
{

    public function save(): Category
    {
        $statement = DB::getPDO()->prepare(
            "INSERT INTO categories (name, image, slug) VALUES (:name, :image, :slug)g"
        );
        $statement->execute([
            'name' => $this->name,
            'image' => $this->image,
            'slug' => $this->slug
        ]);
        return $this;
    }


    public function update(): Category
    {
        $statement = DB::getPDO()->prepare(
            "UPDATE categories SET name = :name, image = :image, slug = :slug WHERE id = :id"
        );
        $statement->execute([
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'slug' => $this->slug,
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