<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/brand.php');
}


$name = trim(strip_tags($_POST['brand_name'] ?? ''));


if ($name === '') {
    $_SESSION['error'] = 'Brand name is required.';
    redirect('../views/admin/brand.php');
}


$controller = new ProductController();

if ($controller->addBrand($name)) {

    $_SESSION['success'] = 'Brand added.';
    redirect('../views/admin/brand.php');
}


$_SESSION['error'] = 'Failed to add brand.';
redirect('../views/admin/brand.php');

?>
