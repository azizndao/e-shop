<?php


use App\clazz\PageMetadata;
use App\models\Article;
use App\models\Category;
use App\models\User;

$currentUser = User::getCurrent();


if ($currentUser == null || !$currentUser->is_admin) {
    header("Location: /404");
}

$errors = [];
$data = $_POST;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($data['name'])) {
        $errors['name'] = "* Requise";
    } else if (strlen($data['name']) < 2) {
        $errors['name'] = "Mot trop court";
    }

    if (!isset($data['price'])) {
        $errors['price'] = "* Requise";
    }

    if (!isset($data['description'])) {
        $errors['description'] = "* Requise";
    }


    if (count($errors) == 0) {
        $article = new Article();

        $article->name = $data['name'];
        $article->price = (float)$data['price'];
        $article->description = $data['description'];
        $article->category_id = (int)$data['category_id'];
        $target_file = 'images/';
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $article->image = $target_file . '/' . $_FILES["fileToUpload"]["name"];
        $article->created_by = $currentUser->id;
        $article->save();
        header('Location: /admin?tab=articles');
    }

}

$categories = Category::getAll();

$metadata = new PageMetadata(
    title: 'Ajouter article | Admin',
    description: 'The admin panel',
    scripts: ['/js/admin_article_add.js'],
    css: ['/css/admin_article_add.css'],
);
?>

<main class="container">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom de l'article</label>
            <input class="form-control" required type="text" name="name" id="name" value="<?= $data['name'] ?>">
        </div>
        <div class="form-group">
            <label for="price">Prix de l'article</label>
            <input class="form-control" required type="text" name="price" id="price" value="<?= $data['price'] ?>">
        </div>
        <div class="form-group">
            <label for="category_id">Marque</label>
            <select class="form-control" name="category_id" id="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="images">Image</label>
            <input type="file" name="images" required id="images" accept="image/*">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" required
                      rows="10"><?= $data['description'] ?></textarea>
        </div>
        <button class="acheter btn btn-neutral">Valider</button>
    </form>
</main>
