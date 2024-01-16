<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\User;

$currentUser = User::getCurrent();

if ($currentUser == null || !$currentUser->is_admin) {
    header("Location: /404");
}

$userId = (int)$_GET['id'];


$user = User::getById($userId);

$articles = Article::getByUserId($userId);

$metadata = new PageMetadata(
    title: $user->getFullName(),
    css: ['/css/admin_user.css']
)
?>

<main class="container">
    <h1><?= $user->getFullName() ?></h1>
    <h3><?= $user->email ?></h3>
    <h3>Produits achetés</h3>

    <section class="articles">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><img src="<?= $article->image ?>" alt="<?= $article->title ?>"></td>
                        <td><?= $article->name ?></td>
                        <td><?= $article->formattedPrice() ?></td>
                        <td><a href="/details?id=<?= $article->id ?>">Voir</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </section>
</main>