```php
<?php
require_once __DIR__ . '/../core/core.php';

$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shoppn</title>

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

        .register-container {
            width: 90%;
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            color: #172554;
        }

        .error-message {
            padding: 12px;
            margin-bottom: 18px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 5px;
        }

        .register-container label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .register-container input:focus,
        .register-container select:focus {
            outline: none;
            border-color: #172554;
        }

        .register-container span[id$="-error"] {
            display: block;
            margin-bottom: 12px;
            color: #b91c1c;
            font-size: 13px;
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            background: #172554;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .register-container button:hover {
            background: #263d78;
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/layout/header.php'; ?>

<div class="register-container">

    <h2>Create Account</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="register-form"
          action="<?= $base_path ?>/actions/register_action.php"
          method="POST">

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name">
        <span id="name-error"></span>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <span id="email-error"></span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="password-error"></span>

        <label for="country">Country:</label>
        <select id="country" name="country">
            <option value="">Select Country</option>
            <option value="Ghana">Ghana</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
        </select>

        <label for="city">City:</label>
        <input type="text" id="city" name="city">

        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact">
        <span id="contact-error"></span>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address">

        <button type="submit">Register</button>

    </form>

</div>

<script src="<?= $base_path ?>/js/validate.js"></script>

<?php include __DIR__ . '/layout/footer.php'; ?>

</body>
</html>
```

