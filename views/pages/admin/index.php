<?php

use App\clazz\PageMetadata;
use App\models\Article;
use App\models\Category;
use App\models\User;

$user = User::getCurrent();

if ($user == null || !$user->is_admin) {
    header("Location: /404");
}

$tab = $_GET['tab'] ?? 'users';


if ($tab == 'users') {
    $users = User::getAll();
} else if ($tab == 'categories') {
    $categories = Category::getAll();
} else if ($tab == 'articles') {
    $articles = Article::getAllWithCategory();
}

$metadata = new PageMetadata(
    title: 'Admin',
    description: 'The admin panel',
    css: ['/css/admin.css'],
);
//dd;
$addLink = $tab == 'articles' ? '/admin/article/add' : '/admin/category';
?>


<main class="container">
    <div class="tabbar">
        <a href="/admin?tab=users">Users</a>
        <a href="/admin?tab=categories">Markes</a>
        <a href="/admin?tab=articles">Produits</a>
        <div class="spacer"></div>
        <?php if ($tab != 'users') : ?>
            <a href="<?= $addLink ?>" class="btn btn-primary">
                Ajouter
            </a>
        <?php endif; ?>
    </div>
    <div class="content">
        <?php if ($tab == 'users') : ?>
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->first_name ?></td>
                        <td><?= $user->last_name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= (bool)$user->is_admin ?></td>
                        <td>
                            <a class="btn btn-neutral" href="/admin/user?id=<?= $user->id ?>">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($tab == 'categories') : ?>
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td class="name"><?= $category->name ?></td>
                        <td class="actions">
                            <a class="btn btn-danger" href="/admin/category?id=<?= $category->id ?>">Edit</a>
                            <a class="btn btn-neutral" href="/categories?id=<?= $category->id ?>">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($tab == 'articles') : ?>
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?= $article->id ?></td>
                        <td><?= $article->name ?></td>
                        <td><?= $article->category_name ?></td>
                        <td>
                            <a class="btn btn-danger" href="/admin/article?id=<?= $article->id ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">
                        <a href="/admin/article/create">Ajouter article</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>
</main>
