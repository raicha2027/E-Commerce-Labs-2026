<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';


$base_path = dirname(dirname($_SERVER['SCRIPT_NAME']));


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $base_path . '/views/login.php');
    exit();
}


$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['password'] ?? '';


if ($email === '' || $pass === '') {

    $_SESSION['error'] = 'Email and password are required.';

    header('Location: ' . $base_path . '/views/login.php');
    exit();
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['error'] = 'Please enter a valid email address.';

    header('Location: ' . $base_path . '/views/login.php');
    exit();
}


$controller = new CustomerController();

$result = $controller->login($email, $pass);


if (isset($result['success']) && $result['success'] === false) {

    $_SESSION['error'] = $result['error'];

    header('Location: ' . $base_path . '/views/login.php');
    exit();
}


$_SESSION['customer_id'] = $result['customer_id'];
$_SESSION['customer_name'] = $result['customer_name'];
$_SESSION['customer_email'] = $result['customer_email'];
$_SESSION['user_role'] = (int) $result['user_role'];


header('Location: ' . $base_path . '/index.php');
exit();

?>

