<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/category.php');
}


$id = $_POST['cat_id'] ?? '';
$name = trim(strip_tags($_POST['cat_name'] ?? ''));


if (!ctype_digit($id) || (int) $id <= 0) {

    $_SESSION['error'] = 'Invalid category ID.';

    redirect('../views/admin/category.php');
}


if ($name === '') {

    $_SESSION['error'] = 'Category name is required.';

    redirect('../views/admin/category.php');
}


$controller = new ProductController();

if ($controller->updateCategory((int) $id, $name)) {

    $_SESSION['success'] = 'Category updated.';

    redirect('../views/admin/category.php');
}


$_SESSION['error'] = 'Failed to update category.';

redirect('../views/admin/category.php');

?>
