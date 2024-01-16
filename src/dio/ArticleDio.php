<?php

namespace App\dio;

use App\models\Article;
use App\utils\DB;
use PDO;

/**
 * Ici nous avons les methodes qui nous permettent d'ajouter, de modifier, de supprimer et de lister les articles
 */
trait ArticleDio
{

    /**
     * Cette methode permet de enregistrer un article
     *
     * @return Article
     */
    public function save(): Article
    {
        $this->created_at = date('Y-m-d H:i:s');
        $statement = DB::getPDO()->prepare(
            "INSERT INTO articles (name, description, price, image, category_id, created_by, created_at) VALUES (:name, :description, :price, :image, :category_id, :created_by, :created_at)"
        );
        $statement->execute([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            "created_by" => $this->created_by,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
        ]);
        return $this;
    }

    /**
     * Cette methode permet de mettre a jour un article
     *
     * @return Article
     */
    public function update(): Article
    {
        $this->updated_at = date('Y-m-d H:i:s');
        $statement = DB::getPDO()->prepare(
            "UPDATE articles SET name = :name, description = :description, image = :image, category_id = :category_id, updated_at = :updated_at WHERE id = :id"
        );
        $statement->execute([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'updated_at' => $this->updated_at,
            "id" => $this->id
        ]);
        return $this;
    }

    /**
     * Cette methode permet de supprimer un article
     *
     * @return void
     */
    public function delete(): void
    {
        $statement = DB::getPDO()->prepare("DELETE FROM articles WHERE id = :id");
        $statement->execute([
            'id' => $this->id
        ]);
    }

    /**
     * Cette methode permet de recuperer tous les articles
     *
     * @return Article[]
     */
    public static function getAll(int $limit = 8): array
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles;");
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    /**
     * Cette methode permet de recuperer un article par son id
     *
     * @param int $id
     * @return Article|null
     */
    public static function getById(int $id): ?Article
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetchObject(Article::class);
    }

    /**
     * Permet de recuperer les articles par category id
     *
     * @param int $categoryId
     * @return Article[]
     */
    public static function getByCategoryId(int $categoryId): array
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles WHERE category_id = ?");
        $stm->execute([$categoryId]);
        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    /**
     * Permet de recuperer les articles avec leurs categories
     *
     * @return Article[]
     */
    public static function getAllWithCategory(): array
    {
        $stm = DB::getPDO()->prepare("SELECT a.*, c.name category_name FROM articles a JOIN eshop.categories c on c.id = a.category_id");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    /**
     * Permet d'acheter un article
     *
     * @param int $userId
     * @return void
     */
    public function buy(int $userId): void
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM buy WHERE article_id = :article_id AND user_id = :user_id");
        $stm->execute([
            'article_id' => $this->id,
            'user_id' => $userId
        ]);

        if ($stm->fetch()) return;

        $stm = DB::getPDO()->prepare("INSERT INTO buy (article_id, user_id) VALUES (:article_id, :user_id)");
        $stm->execute([
            'article_id' => $this->id,
            'user_id' => $userId
        ]);
    }

    /**
     * Permet de supprimer un achat
     *
     * @param int $userId
     * @return void
     */
    public function remove(int $userId): void
    {
        $stm = DB::getPDO()->prepare("DELETE FROM buy WHERE article_id = :article_id AND user_id = :user_id");
        $stm->execute([
            'article_id' => $this->id,
            'user_id' => $userId
        ]);
    }

    /**
     * Permet de recuprer les articles d'une maeque
     *
     * @param int $userId
     * @return Article[]
     */
    public static function getByUserId(int $userId): array
    {
        $stm = DB::getPDO()->prepare("SELECT a.* , buy.created_at buy FROM buy JOIN articles a on buy.article_id = a.id WHERE user_id = :user_id");
        $stm->execute([
            'user_id' => $userId
        ]);
        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    /**
     * Permet de recuprer les articles d'une maeque
     *
     * @param int $userId
     * @return bool
     */
    public function isBought(int $userId): bool
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM buy WHERE article_id = :article_id AND user_id = :user_id");
        $stm->execute([
            'article_id' => $this->id,
            'user_id' => $userId
        ]);
        $result = $stm->fetchObject(Article::class);
        return $result != null;
    }
}
