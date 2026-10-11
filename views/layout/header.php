```php
<?php
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $base_path = '/shoppn';
} else {
    $base_path = '/~raicha.ibrahim/E-commerce/shoppn';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #263238;
        }

        .site-header {
            background: #243b53;
            color: white;
            padding: 20px 5%;
        }

        .site-header h1 {
            margin: 0 0 18px;
            font-size: 28px;
        }

        .nav-bar {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .welcome {
            margin-right: 8px;
            color: #eaf2f8;
        }

        .nav-bar a {
            display: inline-block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 6px;
            transition: background 0.2s;
        }

        .nav-bar a:hover {
            background: #3e5f7d;
        }

        .nav-bar a.active {
            background: #ffffff;
            color: #243b53;
            font-weight: bold;
        }

        .nav-bar a.logout {
            background: #b83232;
            border-color: #b83232;
        }

        .nav-bar a.logout:hover {
            background: #922b21;
        }

        .header-divider {
            border: none;
            border-top: 1px solid #e1e7ed;
            margin: 0;
        }

        @media (max-width: 600px) {
            .site-header {
                padding: 18px 15px;
            }

            .nav-bar {
                gap: 8px;
            }

            .nav-bar a {
                padding: 9px 11px;
            }

            .welcome {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<header class="site-header">

    <h1>Shoppn</h1>

    <nav class="nav-bar">

        <?php if (is_logged_in()): ?>

            <span class="welcome">
                Welcome <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
            </span>

            <a
                href="<?php echo $base_path; ?>/views/account/my_account.php"
                class="<?php echo $current_page === 'my_account.php' ? 'active' : ''; ?>">
                My Account
            </a>

            <?php if (is_admin()): ?>

                <a
                    href="<?php echo $base_path; ?>/views/admin/brand.php"
                    class="<?php echo $current_page === 'brand.php' ? 'active' : ''; ?>">
                    Brand
                </a>

                <a
                    href="<?php echo $base_path; ?>/views/admin/category.php"
                    class="<?php echo $current_page === 'category.php' ? 'active' : ''; ?>">
                    Category
                </a>

                <a

                    href="<?php echo $base_path; ?>/views/admin/product.php"
                    class="<?php echo $current_page === 'product.php' ? 'active' : ''; ?>">
                    Product
                </a>


            <?php endif; ?>

            <a class="logout"
               href="<?php echo $base_path; ?>/logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="<?php echo $base_path; ?>/views/register.php"
               class="<?php echo $current_page === 'register.php' ? 'active' : ''; ?>">
                Register
            </a>

            <a href="<?php echo $base_path; ?>/views/login.php"
               class="<?php echo $current_page === 'login.php' ? 'active' : ''; ?>">
                Login
            </a>

        <?php endif; ?>

    </nav>

</header>

<hr class="header-divider">
```