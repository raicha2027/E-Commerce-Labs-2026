
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Set the correct path for the local or live server.
$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';

// Only administrators can update products.
require_admin();

// Accept POST requests only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base_path . '/views/admin/product.php');
}

// Get product details.
$id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$cat = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);
$title = trim($_POST['product_title'] ?? '');
$price = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);
$desc = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');

// Validate required fields.
if (
    !$id ||
    !$cat ||
    !$brand ||
    $title === '' ||
    $price === false ||
    $price === null ||
    $price < 0
) {
    redirect($base_path . '/views/admin/product.php?error=invalid');
}

$controller = new ProductController();

// Confirm the product exists.
$existing_product = $controller->getProductById($id);

if (!$existing_product) {
    redirect($base_path . '/views/admin/product.php?error=notfound');
}

// Keep the current image unless a new one is uploaded.
$image_filename = $existing_product['product_image'] ?? '';
$image_directory = __DIR__ . '/../images/products/';
$new_image_path = null;

// Check whether a new image was selected.
if (
    isset($_FILES['product_image']) &&
    $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $image = $_FILES['product_image'];

    if ($image['error'] !== UPLOAD_ERR_OK) {
        redirect(
            $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=image'
        );
    }

    // Maximum image size: 5 MB.
    if ($image['size'] > 5 * 1024 * 1024) {
        redirect(
            $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=size'
        );
    }

    // Validate the actual image type.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($image['tmp_name']);

    $allowed_types = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp'
    ];

    if (!isset($allowed_types[$mime_type])) {
        redirect(
            $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=type'
        );
    }

    // Ensure the product image folder exists.
    if (!is_dir($image_directory)) {
        if (!mkdir($image_directory, 0755, true)) {
            redirect(
                $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=folder'
            );
        }
    }

    // Create a unique filename and move the new image.
    $image_filename = uniqid('product_', true) . '.'
        . $allowed_types[$mime_type];

    $new_image_path = $image_directory . $image_filename;

    if (!move_uploaded_file($image['tmp_name'], $new_image_path)) {
        redirect(
            $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=upload'
        );
    }
}

// Update the database through the controller.
$success = $controller->updateProduct(
    $id,
    $cat,
    $brand,
    $title,
    $price,
    $desc,
    $image_filename,
    $keywords
);

if ($success) {
    // Delete the old image only after the database update succeeds.
    $old_image = $existing_product['product_image'] ?? '';

    if (
        $new_image_path !== null &&
        $old_image !== '' &&
        basename($old_image) !== $image_filename
    ) {
        $old_image_path = $image_directory . basename($old_image);

        if (is_file($old_image_path)) {
            unlink($old_image_path);
        }
    }

    redirect($base_path . '/views/admin/product.php?success=updated');
}

// Remove the new upload if the database update fails.
if ($new_image_path !== null && is_file($new_image_path)) {
    unlink($new_image_path);
}

redirect(
    $base_path . '/views/admin/product.php?edit_id=' . $id . '&error=database'
);

?>

