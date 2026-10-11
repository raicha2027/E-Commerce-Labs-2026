```php
<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';

$controller = new ProductController();

$edit_brand = null;

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    if (ctype_digit($edit_id) && (int) $edit_id > 0) {
        $edit_brand = $controller->getBrandById((int) $edit_id);
    }
}

$brands = $controller->getAllBrands();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands - Shoppn</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .brand-container {
            width: 92%;
            max-width: 950px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #172554;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .brand-form {
            margin-bottom: 30px;
        }

        .brand-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .brand-form input {
            width: 100%;
            max-width: 450px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .brand-form button {
            padding: 12px 20px;
            background: #172554;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        .brand-form button:hover {
            background: #263d78;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #172554;
            color: #fff;
        }

        tr:hover td {
            background: #f8fafc;
        }

        td a,
        .home-link {
            color: #172554;
            font-weight: bold;
            text-decoration: none;
        }

        td a:hover,
        .home-link:hover {
            text-decoration: underline;
        }

        .home-link {
            display: inline-block;
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            .brand-container {
                padding: 18px;
            }

            th,
            td {
                padding: 9px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="brand-container">

    <h2>Brands</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <p class="message success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="message error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($edit_brand): ?>

        <form class="brand-form"
              action="<?= $base_path ?>/actions/update_brand_action.php"
              method="POST">

            <input type="hidden" name="brand_id"
                   value="<?= (int) $edit_brand['brand_id'] ?>">

            <label for="brand_name">Brand Name:</label>

            <input type="text"
                   id="brand_name"
                   name="brand_name"
                   value="<?= htmlspecialchars($edit_brand['brand_name']) ?>"
                   required>

            <br>

            <button type="submit">Update Brand</button>

        </form>

    <?php else: ?>

        <form class="brand-form"
              action="<?= $base_path ?>/actions/add_brand_action.php"
              method="POST">

            <label for="brand_name">Brand Name:</label>

            <input type="text"
                   id="brand_name"
                   name="brand_name"
                   required>

            <br>

            <button type="submit">Add Brand</button>

        </form>

    <?php endif; ?>

    <h3>Existing Brands</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($brands as $brand): ?>
                    <tr>
                        <td>
                            <?= (int) $brand['brand_id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($brand['brand_name']) ?>
                        </td>

                        <td>
                            <a href="<?= $base_path ?>/views/admin/brand.php?edit_id=<?= (int) $brand['brand_id'] ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($brands)): ?>
                    <tr>
                        <td colspan="3">No brands have been added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a class="home-link" href="<?= $base_path ?>/index.php">Home</a>

</div>

</body>
</html>
```
