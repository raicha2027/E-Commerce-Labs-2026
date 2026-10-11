```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn - Home</title>

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

        .home-container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
        }

        .welcome-section {
            padding: 65px 35px;
            text-align: center;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .welcome-section h2 {
            margin: 0 0 18px;
            color: #172554;
            font-size: 34px;
        }

        .welcome-section p {
            max-width: 600px;
            margin: 0 auto;
            color: #64748b;
            font-size: 17px;
            line-height: 1.7;
        }

        .home-note {
            margin-top: 30px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .home-container {
                margin: 25px auto;
            }

            .welcome-section {
                padding: 40px 20px;
            }

            .welcome-section h2 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/layout/header.php'; ?>

<main class="home-container">

    <section class="welcome-section">
        <h2>Welcome to Shoppn</h2>

        <p>
            Your online shopping destination. Explore products and enjoy
            a simple and convenient shopping experience.
        </p>
    </section>

    <p class="home-note">
        Thank you for visiting Shoppn.
    </p>

</main>

</body>
</html>
```

