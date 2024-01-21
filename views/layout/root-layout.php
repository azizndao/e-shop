<?php

use App\clazz\PageMetadata;
use App\models\User;

if (!isset($metadata))
    $metadata = new PageMetadata(title: 'Home');
if (!isset($pageContent))
    $pageContent = '';

$user = User::getCurrent();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $metadata->getTitle() ?? 'Home'; ?> - E-Shop
    </title>
    <meta name="description" content="<?= $metadata->getDescription() ?? 'An e-commerce website' ?>">
    <link rel="stylesheet" href="/css/main.css">
    <?php foreach ($metadata->getCss() as $css): ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>
    <script src="/js/main.js" defer type="module"></script>
    <?php foreach ($metadata->getScripts() as $script): ?>
        <script src="<?= $script ?>" defer type="module"></script>
    <?php endforeach; ?>

</head>

<body>
    <header class="app-bar">
        <nav class="nav-bar">
            <a href="/" class="logo">E-Shop</a>

            <aside>
                <?php if (User::isLogIn()): ?>
                    <a href="/profile">
                        Mon espace
                    </a>
                    <a href="/panier">Mon panier</a>
                    <?php if (User::isAdmin()): ?>
                        <a href="/admin">Admin</a>
                    <?php endif ?>
                    <form method="post">
                        <input type="hidden" name="action" value="logout">
                        <button class="btn btn-outline-danger">Se deconnecter</button>
                    </form>
                <?php else: ?>
                    <a href="/register" class="btn btn-outline-danger sign-up">S'inscrire</a>
                    <a href="/login" class="btn btn-primary sign-in">Se connecter</a>
                <?php endif ?>
            </aside>
        </nav>
    </header>

    <?= $pageContent ?>

    <footer class="footer-bar">
        <div class="extra-infos">
            <section><a href="#">Contactez-nous</a>
                <a href="#">Services</a>
                <a href="#">Liens legaux</a>
            </section>
            <section>2024 M1 MIAGE</section>
            <section>
                <div>F</div>
                <div>T</div>
                <div>I</div>
            </section>
        </div>
    </footer>
</body>

</html>