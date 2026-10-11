```php
<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();

$edit_category = null;

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    if (ctype_digit($edit_id) && (int) $edit_id > 0) {
        $edit_category = $controller->getCategoryById((int) $edit_id);
    }
}

$categories = $controller->getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Shoppn</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #263238;
        }

        .page-container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        h2 {
            margin-bottom: 8px;
            color: #243b53;
        }

        .intro {
            color: #627d98;
            margin-bottom: 25px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
        }

        .card h3 {
            margin-top: 0;
            color: #243b53;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            max-width: 500px;
            padding: 12px;
            border: 1px solid #cbd2d9;
            border-radius: 6px;
            font-size: 15px;
            margin-bottom: 16px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #2874a6;
            box-shadow: 0 0 0 2px rgba(40, 116, 166, 0.15);
        }

        button,
        .button-link {
            display: inline-block;
            border: none;
            border-radius: 6px;
            padding: 11px 18px;
            background: #2874a6;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover,
        .button-link:hover {
            background: #1b4f72;
        }

        .cancel-link {
            margin-left: 12px;
            color: #52606d;
            text-decoration: none;
        }

        .message {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .success {
            background: #e5f7ed;
            color: #17663a;
        }

        .error {
            background: #fdecec;
            color: #a12626;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e4e7eb;
        }

        th {
            background: #edf2f7;
            color: #334e68;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .edit-link {
            color: #2874a6;
            font-weight: bold;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        .empty-message {
            color: #627d98;
            padding: 15px 0;
        }

        .home-link {
            display: inline-block;
            margin: 5px 0 25px;
            color: #2874a6;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .page-container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .card {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-container">

    <h2>Category Management</h2>
    <p class="intro">Add new categories and manage existing ones.</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success">
            <?php
            echo htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error">
            <?php
            echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card">

        <?php if ($edit_category): ?>

            <h3>Edit Category</h3>

            <form action="../../actions/update_category_action.php"
                  method="POST">

                <input type="hidden" name="cat_id"
                       value="<?php echo (int) $edit_category['cat_id']; ?>">

                <label for="cat_name">Category Name</label>

                <input type="text"
                       id="cat_name"
                       name="cat_name"
                       minlength="2"
                       maxlength="100"
                       required
                       value="<?php echo htmlspecialchars($edit_category['cat_name']); ?>">

                <br>

                <button type="submit">Update Category</button>

                <a class="cancel-link" href="category.php">Cancel</a>

            </form>

        <?php else: ?>

            <h3>Add New Category</h3>

            <form action="../../actions/add_category_action.php"
                  method="POST">

                <label for="cat_name">Category Name</label>

                <input type="text"
                       id="cat_name"
                       name="cat_name"
                       minlength="2"
                       maxlength="100"
                       required
                       placeholder="Enter category name">

                <br>

                <button type="submit">Add Category</button>

            </form>

        <?php endif; ?>

    </div>

    <div class="card">

        <h3>Existing Categories</h3>

        <?php if (empty($categories)): ?>

            <p class="empty-message">No categories have been added yet.</p>

        <?php else: ?>

            <div class="table-wrapper">

                <table>
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td>
                                    <?php echo (int) $category['cat_id']; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($category['cat_name']); ?>
                                </td>

                                <td>
                                    <a class="edit-link"
                                       href="category.php?edit_id=<?php echo (int) $category['cat_id']; ?>">
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

    <a class="home-link" href="../home.php">← Back to Home</a>

</div>

</body>
</html>
```
