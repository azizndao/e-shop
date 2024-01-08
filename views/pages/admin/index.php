<?php

use App\models\User;

$user = User::getCurrent();

if ($user == null || !$user->is_admin) {
    header("Location: /404");
}
?>


<main class="container">
    <h1><?= $user->first_name ?></h1>

    <h2>Admin panel</h2>
</main>
