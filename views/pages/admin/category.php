<?php

use App\clazz\PageMetadata;
use App\models\Category;
use App\models\User;


$currentUser = User::getCurrent();

if ($currentUser == null || !$currentUser->is_admin) {
    header("Location: /404");
}

$category = isset($_GET['id']) ? Category::getById((int)$_GET['id']) : new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category->name = $_POST['name'];
    if (isset($_GET['id'])) {
        $category->update();
    } else {
        $category->save();
    }
    header("Location: /admin?tab=categories");
}

$metadata = new PageMetadata(
    title: $category->name,
    css: ['/css/admin_category.css'])
?>

<main class="container">
    <form method="post">
        <div class="form-group">
            <label for="name">Nom</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= $category->name ?>">
        </div>
        <button class="btn btn-neutral">Valider</button>
    </form>
</main>