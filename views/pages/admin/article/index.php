<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\User;

$currentUser = User::getCurrent();


if ($currentUser == null || !$currentUser->is_admin) {
    header("Location: /404");
}


$articleId = (int)$_GET['id'];


$article = Article::getById($articleId);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article->name = $_POST['name'];
    $article->description = $_POST['description'];
    $article->update();

    header("Location: /admin?tab=articles");
}

$metadata = new PageMetadata(
    title: $article->name,
    description: $article->description,
    css: ['/css/admin_article.css']
);

?>

<main class="container">
    <form class="buy-form" method="post">
        <div class="container_wrapper">
            <section class="image">
                <img src="<?= $article->image ?>" alt="<?= $article->name ?>">
            </section>
            <aside class="info">
                <header>
                    <h3>
                        Modifier l'article
                    </h3>
                </header>
                <div class="form-group">
                    <label for="name">Nom de l'article</label>
                    <input class="form-control" type="text" name="name" id="name" value="<?= $article->name ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"><?= $article->description ?></textarea>
                </div>
                <button class="acheter btn btn-neutral">Valider</button>
            </aside>
        </div>
    </form>
</main>