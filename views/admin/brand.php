<?php

require_once '../../core/core.php';
require_once '../../controllers/ProductController.php';

require_admin();

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
<html>

<head>
    <title>Brands - Shoppn</title>
</head>

<body>

<?php
include '../layout/header.php';
?>

<h2>Brands</h2>

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

<?php if ($edit_brand): ?>

<form action="../../actions/update_brand_action.php" method="POST">

    <input type="hidden" name="brand_id"
        value="<?php echo $edit_brand['brand_id']; ?>">

    <label>Brand Name:</label><br>

    <input type="text" name="brand_name"
        value="<?php echo htmlspecialchars($edit_brand['brand_name']); ?>">

    <br><br>

    <button type="submit">Update Brand</button>

</form>

<?php else: ?>

<form action="../../actions/add_brand_action.php" method="POST">

    <label>Brand Name:</label><br>

    <input type="text" name="brand_name">

    <br><br>

    <button type="submit">Add Brand</button>

</form>

<?php endif; ?>

<br>

<table border="1">

    <tr>
        <th>Brand ID</th>
        <th>Brand Name</th>
        <th>Action</th>
    </tr>

    <?php foreach ($brands as $brand): ?>

    <tr>

        <td>
            <?php echo htmlspecialchars($brand['brand_id']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($brand['brand_name']); ?>
        </td>

        <td>
            <a href="brand.php?edit_id=<?php echo $brand['brand_id']; ?>">
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
