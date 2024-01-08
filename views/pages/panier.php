<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\User;

$user = User::getCurrent();

if ($user == null) {
    header("Location: /login");
    exit();
}

$articles = Article::getByUserId($user->id);


$metadata = new PageMetadata(
    title: 'Mon panier',
    description: 'Mon panier',
    css: ['/css/panier.css']
);

?>


<main class="container">
    <h1>Les produits achetes</h1>

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