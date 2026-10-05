<?php

require_once '../../core/core.php';
require_once '../../controllers/ProductController.php';

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
<html>

<head>
    <title>Categories - Shoppn</title>
</head>

<body>

<?php
include '../layout/header.php';
?>

<h2>Categories</h2>

<?php

if (isset($_SESSION['success'])) {
    echo '<p>' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

?>

<?php if ($edit_category): ?>

<form action="../../actions/update_category_action.php" method="POST">

    <input type="hidden" name="cat_id"
        value="<?php echo $edit_category['cat_id']; ?>">

    <label>Category Name:</label><br>

    <input type="text" name="cat_name"
        value="<?php echo htmlspecialchars($edit_category['cat_name']); ?>">

    <br><br>

    <button type="submit">Update Category</button>

</form>

<?php else: ?>

<form action="../../actions/add_category_action.php" method="POST">

    <label>Category Name:</label><br>

    <input type="text" name="cat_name">

    <br><br>

    <button type="submit">Add Category</button>

</form>

<?php endif; ?>

<br>

<table border="1">

    <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Action</th>
    </tr>

    <?php foreach ($categories as $category): ?>

    <tr>

        <td>
            <?php echo htmlspecialchars($category['cat_id']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($category['cat_name']); ?>
        </td>

        <td>
            <a href="category.php?edit_id=<?php echo $category['cat_id']; ?>">
                Edit
            </a>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<br>

<a href="../home.php">Home</a>

</body>

</html>
