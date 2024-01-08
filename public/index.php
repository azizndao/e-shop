<?php
session_start();

require '../vendor/autoload.php';


$path = $_SERVER['PATH_INFO'] ?? '/';

ob_start();
if ($path === '' || $path === '/') {
    require '../views/pages/home.php';
} else if (file_exists("../views/pages/$path.php")) {
    require "../views/pages/$path.php";
} else if (file_exists("../views/pages/$path/index.php")) {
    require "../views/pages/$path/index.php";
} else {
    require '../views/pages/404.php';
}

$pageContent = ob_get_clean();

require '../views/layout/root-layout.php';
