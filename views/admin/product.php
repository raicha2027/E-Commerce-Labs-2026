
<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';

require_admin();

$controller = new ProductController();

$edit_mode = false;
$product = null;
$error_message = '';
$success_message = '';

if (isset($_GET['edit_id'])) {
    $edit_id = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);

    if (!$edit_id || $edit_id < 1) {
        redirect($base_path . '/views/admin/product.php?error=notfound');
    }

    $product = $controller->getProductById($edit_id);

    if (!$product) {
        redirect($base_path . '/views/admin/product.php?error=notfound');
    }

    $edit_mode = true;
}

$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
$products = $controller->getAllProducts();

$errors = [
    'invalid'  => 'Please complete all required fields correctly.',
    'image'    => 'Please select a valid image to upload.',
    'size'     => 'The image must not exceed 5 MB.',
    'type'     => 'Only JPG, PNG, GIF, and WEBP images are allowed.',
    'folder'   => 'The image folder could not be created.',
    'upload'   => 'The image could not be uploaded. Please try again.',
    'database' => 'The product could not be saved. Please try again.',
    'notfound' => 'The requested product was not found.'
];

if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
    $error_message = $errors[$_GET['error']];
}

if (isset($_GET['success']) && $_GET['success'] === 'added') {
    $success_message = 'Product added successfully!';
}

if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    $success_message = 'Product updated successfully!';
}

require_once __DIR__ . '/../layout/header.php';

?>

<style>
.product-page {
    max-width: 1150px;
    margin: 35px auto;
    padding: 0 20px 40px;
    color: #243047;
    font-family: Arial, sans-serif;
}

.product-heading {
    margin-bottom: 25px;
}

.product-heading h1 {
    margin-bottom: 8px;
    color: #172554;
    font-size: 28px;
}

.product-heading p {
    color: #64748b;
    margin: 0;
}

.product-card,
.product-list-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06);
}

.product-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-weight: 600;
    font-size: 14px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    font-size: 14px;
    background: #fff;
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-help {
    color: #64748b;
    font-size: 12px;
}

.current-image,
.image-preview {
    width: 130px;
    height: 110px;
    object-fit: contain;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 5px;
    background: #f8fafc;
}

.image-preview {
    display: none;
    margin-top: 10px;
}

.form-actions {
    grid-column: 1 / -1;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 11px 17px;
    border: none;
    border-radius: 7px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
}

.btn-primary {
    background: #1d4ed8;
    color: white;
}

.btn-primary:hover {
    background: #1e40af;
}

.btn-secondary {
    background: #e2e8f0;
    color: #334155;
}

.btn-edit {
    background: #dbeafe;
    color: #1d4ed8;
    padding: 8px 12px;
}

.alert {
    padding: 13px 16px;
    border-radius: 7px;
    margin-bottom: 20px;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
}

.table-wrapper {
    overflow-x: auto;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.product-table th,
.product-table td {
    text-align: left;
    padding: 13px 12px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
}

.product-table th {
    background: #f8fafc;
    color: #334155;
}

.product-table tr:hover {
    background: #f8fafc;
}

.product-thumb {
    width: 65px;
    height: 60px;
    object-fit: contain;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 3px;
    background: white;
}

.empty-products {
    text-align: center;
    color: #64748b;
    padding: 25px;
}

@media (max-width: 650px) {
    .product-form {
        grid-template-columns: 1fr;
    }

    .form-group.full-width,
    .form-actions {
        grid-column: 1;
    }

    .product-card,
    .product-list-card {
        padding: 16px;
    }
}
</style>

<div class="product-page">

    <div class="product-heading">
        <h1><?php echo $edit_mode ? 'Edit Product' : 'Product Management'; ?></h1>
        <p>
            Add products to your store or manage products you have already added.
        </p>
    </div>

    <?php if ($error_message !== ''): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php if ($success_message !== ''): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="product-card">

        <h2><?php echo $edit_mode ? 'Edit Product Details' : 'Add New Product'; ?></h2>

        <?php if (empty($categories) || empty($brands)): ?>

            <div class="alert alert-error">
                Add at least one category and one brand before adding a product.
                <a href="<?php echo $base_path; ?>/views/admin/category.php">Manage Categories</a>
                |
                <a href="<?php echo $base_path; ?>/views/admin/brand.php">Manage Brands</a>
            </div>

        <?php else: ?>

            <form
                class="product-form"
                action="<?php echo $base_path; ?>/actions/<?php echo $edit_mode ? 'update_product_action.php' : 'add_product_action.php'; ?>"
                method="POST"
                enctype="multipart/form-data"
                id="productForm"
            >

                <?php if ($edit_mode): ?>
                    <input type="hidden" name="product_id"
                           value="<?php echo (int) $product['product_id']; ?>">

                    <input type="hidden" name="existing_image"
                           value="<?php echo htmlspecialchars($product['product_image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php endif; ?>

                <div class="form-group full-width">
                    <label for="product_title">Product Title *</label>
                    <input type="text" id="product_title" name="product_title"
                           maxlength="200" required
                           value="<?php echo htmlspecialchars($product['product_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                           placeholder="Enter product title">
                </div>

                <div class="form-group">
                    <label for="product_cat">Category *</label>
                    <select id="product_cat" name="product_cat" required>
                        <option value="">Select a category</option>

                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo (int) $category['cat_id']; ?>"
                                <?php echo $edit_mode && (int) $product['product_cat'] === (int) $category['cat_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['cat_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_brand">Brand *</label>
                    <select id="product_brand" name="product_brand" required>
                        <option value="">Select a brand</option>

                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo (int) $brand['brand_id']; ?>"
                                <?php echo $edit_mode && (int) $product['product_brand'] === (int) $brand['brand_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($brand['brand_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_price">Price (GHS) *</label>
                    <input type="number" id="product_price" name="product_price"
                           min="0" step="0.01" required
                           value="<?php echo $edit_mode ? htmlspecialchars((string) $product['product_price'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           placeholder="e.g. 50.00">
                </div>

                <div class="form-group">
                    <label for="product_keywords">Keywords</label>
                    <input type="text" id="product_keywords" name="product_keywords"
                           value="<?php echo htmlspecialchars($product['product_keywords'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                           placeholder="e.g. shoes, casual, fashion">
                </div>

                <div class="form-group full-width">
                    <label for="product_desc">Description</label>
                    <textarea id="product_desc" name="product_desc"
                              maxlength="500"
                              placeholder="Describe the product"><?php
                        echo htmlspecialchars($product['product_desc'] ?? '', ENT_QUOTES, 'UTF-8');
                    ?></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="product_image">
                        Product Image <?php echo $edit_mode ? '(Optional)' : '*'; ?>
                    </label>

                    <?php if ($edit_mode && !empty($product['product_image'])): ?>
                        <p class="form-help">Current image:</p>
                        <img class="current-image"
                             src="<?php echo $base_path; ?>/images/products/<?php echo rawurlencode(basename($product['product_image'])); ?>"
                             alt="Current product image">
                    <?php endif; ?>

                    <input type="file" id="product_image" name="product_image"
                           accept="image/jpeg,image/png,image/gif,image/webp"
                           <?php echo $edit_mode ? '' : 'required'; ?>>

                    <span class="form-help">JPG, PNG, GIF, or WEBP. Maximum size: 5 MB.</span>

                    <img id="imagePreview" class="image-preview" alt="Selected image preview">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $edit_mode ? 'Update Product' : 'Add Product'; ?>
                    </button>

                    <?php if ($edit_mode): ?>
                        <a href="<?php echo $base_path; ?>/views/admin/product.php"
                           class="btn btn-secondary">Cancel Edit</a>
                    <?php endif; ?>
                </div>

            </form>

        <?php endif; ?>

    </div>

    <div class="product-list-card">

        <h2>Existing Products</h2>

        <?php if (empty($products)): ?>

            <div class="empty-products">No products have been added yet.</div>

        <?php else: ?>

            <div class="table-wrapper">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price (GHS)</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($products as $item): ?>
                            <tr>
                                <td><?php echo (int) $item['product_id']; ?></td>

                                <td>
                                    <?php if (!empty($item['product_image'])): ?>
                                        <img
                                            class="product-thumb"
                                            src="<?php echo $base_path; ?>/images/products/<?php echo rawurlencode(basename($item['product_image'])); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_title'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php else: ?>
                                        No image
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item['product_title'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item['cat_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item['brand_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <td>
                                    <?php echo number_format((float) $item['product_price'], 2); ?>
                                </td>

                                <td>
                                    <a class="btn btn-edit"
                                       href="<?php echo $base_path; ?>/views/admin/product.php?edit_id=<?php echo (int) $item['product_id']; ?>">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

</div>

<script>
const productForm = document.getElementById('productForm');
const imageInput = document.getElementById('product_image');
const imagePreview = document.getElementById('imagePreview');

if (imageInput && imagePreview) {
    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        imagePreview.style.display = 'none';
        imagePreview.removeAttribute('src');

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a JPG, PNG, GIF, or WEBP image.');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('The image must not exceed 5 MB.');
            this.value = '';
            return;
        }

        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    });
}

if (productForm) {
    productForm.addEventListener('submit', function (event) {
        const priceInput = document.getElementById('product_price');

        if (Number(priceInput.value) < 0) {
            event.preventDefault();
            alert('Price cannot be negative.');
        }
    });
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
