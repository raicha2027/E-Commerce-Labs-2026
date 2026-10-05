<?php

require_once '../../core/core.php';

require_login();

?>

<!DOCTYPE html>
<html>

<head>
    <title>My Account - Shoppn</title>
</head>

<body>

<?php
include '../layout/header.php';
?>

<h2>My Account</h2>

<p>
    Welcome to your account.
</p>

<p>
    Customer ID:
    <?php echo htmlspecialchars($_SESSION['customer_id']); ?>
</p>

<p>
    Name:
    <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
</p>

<p>
    Email:
    <?php echo htmlspecialchars($_SESSION['customer_email']); ?>
</p>

<p>
    User Role:
    <?php echo htmlspecialchars($_SESSION['user_role']); ?>
</p>

<a href="/shoppn/index.php">
    Home
</a>

</body>

</html>
