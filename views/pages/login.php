<?php

use App\clazz\PageMetadata;
use App\models\User;

$redirect = $_GET['redirect'] ?? '/profile';

if (User::isLogIn()) {
    header('Location: /profile');
    exit;
}

$data = $_POST;

$errors = [];

// new password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = User::login($data);
    if (empty($errors)) {
        header("Location: $redirect");
        exit();
    }
}

$metadata = new PageMetadata(
    title: 'Login',
    description: 'The login page',
    scripts: ['/js/login.js'],
    css: ['/css/login.css']
);
?>

<main class="container">
    <form action="/login" method="post" class="sign-in-form">
        <h1>Bienvenu 👋</h1>
        <?php if (!empty($errors)) : ?>
            <p class="error-message">Identifient ou mot de passe invalide</p>
        <?php endif; ?>
        <div class="form-group">
            <label for="email">Votre email</label>
            <input type="email" autocomplete="email" name="email" id="email" placeholder="poulo@dierri.sn" required value="<?= $data['email'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" autocomplete="current-password" name="password" id="password" placeholder="********" required>
        </div>
        <button type="submit" class="btn btn-primary">Connecter</button>
        <p class="sign-up-message"><small><a href="/register?redirect=<?= $redirect ?>">S'inscrire</a> si vous avez pas de compte</small></p>
    </form>
</main>