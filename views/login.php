<?php

require_once '../core/core.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Shoppn</title>
</head>

<body>

<?php
include 'layout/header.php';
?>

<h2>Login</h2>


<?php

if (isset($_SESSION['error'])) {

    echo '<p>' . htmlspecialchars($_SESSION['error']) . '</p>';

    unset($_SESSION['error']);
}

?>


<form action="../actions/login_action.php" method="POST">

    <label>Email:</label><br>

    <input
        type="email"
        name="email"
        required
    >

    <br><br>


    <label>Password:</label><br>

    <input
        type="password"
        name="password"
        required
    >

    <br><br>


    <button type="submit">
        Login
    </button>

</form>


<p>
    Don't have an account?
    <a href="register.php">Register</a>
</p>


</body>

</html>
