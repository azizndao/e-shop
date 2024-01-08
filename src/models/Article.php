<?php

namespace App\models;

use App\dio\ArticleDio;

class Article
{

    use ArticleDio;


    public int $id;
    public string $name;
    public string $description;
    public string $image;
    public float $price;
    public int $category_id;
    public int $created_by;
    public string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;


    public function formattedPrice(): string
    {
        return  number_format($this->price, 0, ',', ' ') . ' XOF';
    }
}
