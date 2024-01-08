<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\Category;

$categoryId = (int)$_GET['id'];

if (!isset($categoryId)) {
    header("Location: /404.php");
}

$category = Category::getById($categoryId);
$articles = Article::getByCategoryId($categoryId);

$metadata = new PageMetadata(
    title: $category->name,
    description: '$article->description',
    scripts: ['/js/category.js'],
    css: ['/css/category.css'],
);
?>

<main class="container">
    <h1>
        <?= $category->name ?>
    </h1>
    <section class="article-grid">
        <?php foreach ($articles as $article) : ?>
            <a href="/details?id=<?= $article->id ?>">
                <article class="article">
                    <p class="name">
                        <?= $article->name ?>
                    </p>
                    <p class="price"><?= $article->formattedPrice() ?></p>
                    <img src="<?= $article->image ?>" alt="">
                </article>
            </a>
        <?php endforeach; ?>
    </section>
</main>
