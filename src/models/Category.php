<?php

namespace App\models;

use App\dio\CategoryDio;

class Category
{
    use CategoryDio;

    public int $id;
    public string $name;
    public string $image;
    public ?string $slug;
}
