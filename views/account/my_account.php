```php
<?php

require_once __DIR__ . '/../../core/core.php';

require_login();

$base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? '/shoppn'
    : '/~raicha.ibrahim/E-commerce/shoppn';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Shoppn</title>

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

        .account-container {
            width: 90%;
            max-width: 650px;
            margin: 45px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .account-container h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #172554;
        }

        .welcome-text {
            margin-bottom: 25px;
            color: #666;
        }

        .account-detail {
            padding: 15px;
            margin-bottom: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
        }

        .account-detail strong {
            display: inline-block;
            min-width: 120px;
            color: #172554;
        }

        .home-button {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 22px;
            background: #172554;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .home-button:hover {
            background: #263d78;
        }

        @media (max-width: 480px) {
            .account-container {
                padding: 20px;
            }

            .account-detail strong {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="account-container">

    <h2>My Account</h2>

    <p class="welcome-text">
        Welcome to your account.
    </p>

    <div class="account-detail">
        <strong>Customer ID:</strong>
        <?= htmlspecialchars((string) ($_SESSION['customer_id'] ?? '')) ?>
    </div>

    <div class="account-detail">
        <strong>Name:</strong>
        <?= htmlspecialchars((string) ($_SESSION['customer_name'] ?? '')) ?>
    </div>

    <div class="account-detail">
        <strong>Email:</strong>
        <?= htmlspecialchars((string) ($_SESSION['customer_email'] ?? '')) ?>
    </div>

    <div class="account-detail">
        <strong>User Role:</strong>
        <?= htmlspecialchars((string) ($_SESSION['user_role'] ?? '')) ?>
    </div>

    <a class="home-button" href="<?= $base_path ?>/index.php">
        Home
    </a>

</div>

</body>
</html>
```
