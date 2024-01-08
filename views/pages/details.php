<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\User;


$articleId = (int)$_GET['id'];

if (!isset($articleId)) {
    header("Location: /404");
}

$article = Article::getById($articleId);

if ($article == null) {
    header("Location: /404");
}


$user = User::getCurrent();
$isBought = !($user == null) && $article->isBought($user->id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = User::getCurrent();
    if ($user == null) {
        header("Location: /login?redirect=/details?id=$articleId");
        exit();
    }
    $action = $_POST['action'];
    if ($action == 'add') {
        $article->buy($user->id);
        header("Location: /panier");
    } else {
        $article->remove($user->id);
        $isBought = false;
    }
}

$metadata = new PageMetadata(
    title: $article->name,
    description: $article->description,
    scripts: ['/js/details.js'],
    css: ['/css/details.css'],
);

?>


<main class="container">
    <div class="main_wrapper">
        <section class="image">
            <img src="<?= $article->image ?>" alt="<?= $article->name ?>">
        </section>
        <aside class="info">
            <header>
                <h3>
                    <span class="name"><?= $article->name ?></span>
                    <span class="price"><?= $article->formattedPrice() ?></span>
                </h3>
            </header>
            <div class="separateur"></div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid aspernatur atque beatae,
                cumque
                cupiditate dolor eius eligendi explicabo hic iste minus necessitatibus non officia quis quisquam
                repellat
                voluptate voluptates!
            </p>
            <form class="buy-form" method="post">
                <input type="hidden" name="id" value="<?= $article->id ?>">
                <input type="hidden" name="action" value="<?= $isBought ? 'remove' : 'add' ?>">
                <button class="acheter btn <?= $isBought ? 'btn-danger' : 'btn-neutral' ?>"><?= $isBought ? 'Supprimer' : 'Acheter' ?></button>
            </form>
        </aside>
    </div>
</main>