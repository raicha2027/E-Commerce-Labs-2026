<?php
require_once '../core/core.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Shoppn</title>
</head>

<body>

<?php
include 'layout/header.php';
?>

<h2>Create Account</h2>

<?php
if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>

<form id="register-form" action="../actions/register_action.php" method="POST">

    <label>Full Name:</label><br>
    <input type="text" id="name" name="name">
    <span id="name-error"></span>
    <br><br>

    <label>Email:</label><br>
    <input type="email" id="email" name="email">
    <span id="email-error"></span>
    <br><br>

    <label>Password:</label><br>
    <input type="password" id="password" name="password">
    <span id="password-error"></span>
    <br><br>

    <label>Country:</label><br>
    <select id="country" name="country">
        <option value="">Select Country</option>
        <option value="Ghana">Ghana</option>
        <option value="Niger">Niger</option>
        <option value="Nigeria">Nigeria</option>
    </select>
    <br><br>

    <label>City:</label><br>
    <input type="text" id="city" name="city">
    <br><br>

    <label>Contact Number:</label><br>
    <input type="text" id="contact" name="contact">
    <span id="contact-error"></span>
    <br><br>

    <label>Address:</label><br>
    <input type="text" id="address" name="address">
    <br><br>

    <button type="submit">Register</button>

</form>

<script src="../js/validate.js"></script>

<?php
include 'layout/footer.php';
?>

</body>
</html>
