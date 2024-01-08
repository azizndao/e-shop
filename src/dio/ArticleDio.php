<?php

namespace App\dio;

use App\models\Article;
use App\utils\DB;
use DateTime;
use PDO;

trait ArticleDio
{

    public function save(): Article
    {
        $statement = DB::getPDO()->prepare(
            "INSERT INTO articles (name, image, category_id, created_by) VALUES (:name, :image_url, :category_id, :created_by)"
        );
        $statement->execute([
            'name' => $this->name,
            'image_url' => $this->image_url,
            'category_id' => $this->category_id,
            'created_by' => $this->created_by
        ]);
        $stm = DB::getPDO()->prepare("SELECT * FROM articles WHERE id = ?");
        $stm->execute([$this->getPDO()->lastInsertId()]);
        dd($stm->fetchObject(Article::class));
    }

    public function delete(): void
    {
        $statement = DB::getPDO()->prepare("DELETE FROM articles WHERE id = :id");
        $statement->execute([
            'id' => $this->id
        ]);
    }

    public function update(): Article
    {
        $this->updated_at = new DateTime();
        $statement = DB::getPDO()->prepare(
            "UPDATE articles SET name = :name, image = :image_url, category_id = :category_id WHERE id = :id"
        );
        $statement->execute([
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'category_id' => $this->category_id,
            'updated_by' => $this->updated_at
        ]);
        return $this;
    }

    /**
     * @return Article[]
     */
    public static function getAll(int $limit = 8): array
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles;");
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    public static function getById(int $id): ?Article
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetchObject(Article::class);
    }

    /**
     * @param int $categoryId
     * @return Article[]
     */
    public static function getByCategoryId(int $categoryId): array
    {
        $stm = DB::getPDO()->prepare("SELECT * FROM articles WHERE category_id = ?");
        $stm->execute([$categoryId]);
        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

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

    public function remove(int $userId): void
    {
        $stm = DB::getPDO()->prepare("DELETE FROM buy WHERE article_id = :article_id AND user_id = :user_id");
        $stm->execute([
            'article_id' => $this->id,
            'user_id' => $userId
        ]);
    }

    public static function getByUserId(int $userId): array
    {
        $stm = DB::getPDO()->prepare("SELECT a.* FROM buy JOIN articles a on buy.article_id = a.id WHERE user_id = :user_id");
        $stm->execute([
            'user_id' => $userId
        ]);
        return $stm->fetchAll(PDO::FETCH_CLASS, Article::class);
    }


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
