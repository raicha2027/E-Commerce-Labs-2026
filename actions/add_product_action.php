
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Set the correct path for the local or live server.
$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';

// Only administrators can add products.
require_admin();

// Accept POST requests only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base_path . '/views/admin/product.php');
}

// Collect form data.
$cat = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);
$title = trim($_POST['product_title'] ?? '');
$price = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);
$desc = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');

// Validate required fields.
if (
    !$cat ||
    !$brand ||
    $title === '' ||
    $price === false ||
    $price === null ||
    $price < 0
) {
    redirect($base_path . '/views/admin/product.php?error=invalid');
}

// Check image upload.
if (
    !isset($_FILES['product_image']) ||
    $_FILES['product_image']['error'] !== UPLOAD_ERR_OK
) {
    redirect($base_path . '/views/admin/product.php?error=image');
}

$image = $_FILES['product_image'];

// Maximum image size: 5 MB.
if ($image['size'] > 5 * 1024 * 1024) {
    redirect($base_path . '/views/admin/product.php?error=size');
}

// Validate the actual image MIME type.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($image['tmp_name']);

$allowed_types = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp'
];

if (!isset($allowed_types[$mime_type])) {
    redirect($base_path . '/views/admin/product.php?error=type');
}

// Confirm the products image folder exists.
$image_directory = __DIR__ . '/../images/products/';

if (!is_dir($image_directory)) {
    if (!mkdir($image_directory, 0755, true)) {
        redirect($base_path . '/views/admin/product.php?error=folder');
    }
}

// Generate a unique image filename.
$image_filename = uniqid('product_', true) . '.'
    . $allowed_types[$mime_type];

$image_path = $image_directory . $image_filename;

// Save the uploaded image.
if (!move_uploaded_file($image['tmp_name'], $image_path)) {
    redirect($base_path . '/views/admin/product.php?error=upload');
}

// Insert the product through the controller.
$controller = new ProductController();

$success = $controller->addProduct(
    $cat,
    $brand,
    $title,
    $price,
    $desc,
    $image_filename,
    $keywords
);

if ($success) {
    redirect($base_path . '/views/admin/product.php?success=added');
}

// Remove the image if saving the product fails.
if (file_exists($image_path)) {
    unlink($image_path);
}

redirect($base_path . '/views/admin/product.php?error=database');

?>
