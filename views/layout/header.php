<?php
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $base_path = '/shoppn';
} else {
    $base_path = '/~raicha.ibrahim/E-commerce/shoppn';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shoppn</title>
</head>
<body>

<h1>Shoppn</h1>

<nav>

<?php if (is_logged_in()): ?>

    Welcome <?php echo htmlspecialchars($_SESSION['customer_name']); ?> |

    <a href="<?php echo $base_path; ?>/views/account/my_account.php">My Account</a> |

    <?php if (is_admin()): ?>
        <a href="<?php echo $base_path; ?>/views/admin/brand.php">Brand</a> |
        <a href="<?php echo $base_path; ?>/views/admin/category.php">Category</a> |
    <?php endif; ?>

    <a href="<?php echo $base_path; ?>/logout.php">Logout</a>

<?php else: ?>

    <a href="<?php echo $base_path; ?>/views/register.php">Register</a> |
    <a href="<?php echo $base_path; ?>/views/login.php">Login</a>

<?php endif; ?>

</nav>

<hr>
