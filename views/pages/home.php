<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\Category;

$marks = Category::getAll();
$articles = Article::getAll();

$metadata = new PageMetadata(
    title: 'Home',
    description: 'E commerce web site',
    scripts: ['/js/home.js'],
    css: ['/css/home.css'],
);

?>

<header class="menubar">
    <ul class="menu-list">
        <li><a class="news" href="#">Nouveautes</a></li>
        <div class="spacer"></div>
        <?php foreach ($marks as $mark) : ?>
            <li><a href="/categories?id=<?= $mark->id ?>"><?= $mark->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</header>

<section class="top-content">

    <section class="carousel">
        <div class="carousel-slider">
            <div class="slide">
                <img src="/images/slide-1.jpeg" alt="" />
            </div>
            <div class="slide">
                <img src="/images/slide-2.png" alt="" />
            </div>
            <li class="slide"></li>
        </div>
    </section>
</section>
<main class="container">

    <section class="showcases">
        <article class="showcase">
            <img src="/images/slide-1.jpeg" alt="" />
        </article>
        <article class="showcase">
            <img src="/images/slide-2.png" alt="" />
        </article>
    </section>

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