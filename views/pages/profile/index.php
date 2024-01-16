<?php

use App\clazz\PageMetadata;
use App\models\User;


$user = User::getCurrent();

if ($user == null) {
    header('Location: /login?redirect=/profile');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'logout') {
        $user->logout();
        header('Location: /login?redirect=/profile');
        exit();
    } else if ($action == 'update-profile') {
        $updateProfileErrors = $user->tryUpdateProfile($_POST);
    } else if ($action == 'update-password') {
        $updatePasswordErrors = $user->tryUpdatePassword($_POST);
        User::logout();
        header('Location: /login');
    }
}

$metadata = new PageMetadata(
    title: 'profile',
    description: '',
    css: ['/css/profile.css', '/css/components/form.css'],
);

?>

<main class="container">

    <section class="personal__info">
        <?php require('../views/partials/profile/update-profile.php') ?>
    </section>

    <section class="password__change">
        <?php require('../views/partials/profile/update-password.php') ?>
    </section>

    <section class="destroy__account">
        <form method="post">
            <input type="hidden" name="action" value="logout">
            <button class="btn btn-outline-danger">Logout</button>
        </form>
    </section>
</main>