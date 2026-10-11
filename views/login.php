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
    <title>Login - Shoppn</title>

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

        .login-container {
            width: 90%;
            max-width: 420px;
            margin: 60px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
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

        .login-container label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .login-container input:focus {
            outline: none;
            border-color: #172554;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background: #172554;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background: #263d78;
        }

        .register-link {
            margin-top: 20px;
            text-align: center;
        }

        .register-link a {
            color: #172554;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/layout/header.php'; ?>

<div class="login-container">

    <h2>Login to Shoppn</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?= $base_path ?>/actions/login_action.php" method="POST">

        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <label for="password">Password:</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <button type="submit">Login</button>

    </form>

    <p class="register-link">
        Don't have an account?
        <a href="<?= $base_path ?>/views/register.php">Register</a>
    </p>

</div>

</body>
</html>
```

