<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/category.php');
}


$name = trim(strip_tags($_POST['cat_name'] ?? ''));


if ($name === '') {
    $_SESSION['error'] = 'Category name is required.';
    redirect('../views/admin/category.php');
}


$controller = new ProductController();

if ($controller->addCategory($name)) {

    $_SESSION['success'] = 'Category added.';
    redirect('../views/admin/category.php');
}


$_SESSION['error'] = 'Failed to add category.';
redirect('../views/admin/category.php');

?>
