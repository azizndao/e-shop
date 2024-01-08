<?php

use App\clazz\PageMetadata;
use App\models\User;

if (User::isLogIn()) {
    header('Location: /profile');
    exit;
}

$data = $_POST;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = User::register($data);

    if (empty($errors)) {
        header('Location: /profile');
        exit();
    }
}

$metadata = new PageMetadata(
    title: 'Sign up',
    description: 'The registration page',
    scripts: ['/js/register.js'],
    css: ['/css/register.css']
) ?>

<main class="container">
    <form action="/register" method="post" class="sign-up-form">
        <h1>Bienvenu dans E-Shop</h1>
        <section class="name">
            <div class="form-group">
                <label for="first-name">Votre prenom</label>
                <input type="text" autocomplete="given-name" name="first_name" id="first-name" placeholder="Poulo" value="<?= $data['first_name'] ?? '' ?>">
                <?php if (!empty($errors['first_name'])) : ?>
                    <small class="input-error">
                        <?= $errors['first_name'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="last-name">Votre nom</label>
                <input type="text" autocomplete="family-name" name="last_name" id="last-name" placeholder="Dierri" value="<?= $data['last_name'] ?? '' ?>" aria-errormessage="<?= $errors['last_name'] ?>">
                <?php if (!empty($errors['last_name'])) : ?>
                    <small class="input-error">
                        <?= $errors['last_name'] ?>
                    </small>
                <?php endif; ?>
            </div>
        </section>
        <div class="form-group">
            <label for="email">Votre email</label>
            <input type="email" autocomplete="email" name="email" id="email" placeholder="poulo@dierri.sn" value="<?= $data['email'] ?? '' ?>">
            <?php if (!empty($errors['email'])) : ?>
                <small class="input-error">
                    <?= $errors['email'] ?>
                </small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="mobile">Votre telephone</label>
            <input type="number" autocomplete="mobile" name="mobile" id="mobile" value="<?= $data['mobile'] ?? '' ?>" placeholder="ex: +221 77 622 62 32">
            <?php if (!empty($errors['mobile'])) : ?>
                <small class="input-error">
                    <?= $errors['mobile'] ?>
                </small>
            <?php endif; ?>
        </div>
        <section class="secret">
            <div class="form-group">
                <label for="password">Créer un mot de passe</label>
                <input type="password" autocomplete="new-password" name="password" id="password" placeholder="********">
                <?php if (!empty($errors['password'])) : ?>
                    <small class="input-error">
                        <?= $errors['password'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password-confirmation">Confirmer votre mot de passe</label>
                <input type="password" autocomplete="new-password" name="password-confirmation" id="password-confirmation" placeholder="********">
                <?php if (!empty($errors['password-confirmation'])) : ?>
                    <small class="input-error">
                        <?= $errors['password-confirmation'] ?>
                    </small>
                <?php endif; ?>
            </div>
        </section>

        <div class="from-checkbox">
            <input type="checkbox" name="term-of-service" id="term-of-service">
            <label for="term-of-service"><small>Accepter les termes du contrats</small></label>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</main>