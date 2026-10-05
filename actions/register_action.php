<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/register.php');
}

$name = trim(strip_tags($_POST['name'] ?? ''));
$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['password'] ?? '';
$country = trim(strip_tags($_POST['country'] ?? ''));
$city = trim(strip_tags($_POST['city'] ?? ''));
$contact = trim(strip_tags($_POST['contact'] ?? ''));

if (
    $name === '' ||
    $email === '' ||
    $pass === '' ||
    $country === '' ||
    $city === '' ||
    $contact === ''
) {
    $_SESSION['error'] = 'All fields are required.';
    redirect('../views/register.php');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    redirect('../views/register.php');
}

if (strlen($name) > 100) {
    $_SESSION['error'] = 'Name is too long.';
    redirect('../views/register.php');
}

if (strlen($email) > 50) {
    $_SESSION['error'] = 'Email is too long.';
    redirect('../views/register.php');
}

if (strlen($country) > 30) {
    $_SESSION['error'] = 'Country is too long.';
    redirect('../views/register.php');
}

if (strlen($city) > 30) {
    $_SESSION['error'] = 'City is too long.';
    redirect('../views/register.php');
}

if (strlen($contact) > 15) {
    $_SESSION['error'] = 'Contact number is too long.';
    redirect('../views/register.php');
}

if (!preg_match('/^(?=.*\d).{8,}$/', $pass)) {
    $_SESSION['error'] = 'Password must be at least 8 characters and contain a number.';
    redirect('../views/register.php');
}

$data = [
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact
];

$controller = new CustomerController();
$result = $controller->register($data);

if ($result['success']) {
   $_SESSION['customer_id'] = $result['customer_id'];
   $_SESSION['customer_name'] = $name;
   $_SESSION['customer_email'] = $email;
   $_SESSION['user_role'] = 2;
   

    redirect('../views/account/my_account.php');
}

$_SESSION['error'] = $result['error'];
redirect('../views/register.php');
?>
