<?php

session_start();

date_default_timezone_set('Africa/Accra');

require_once __DIR__ . '/db_class.php';


function get_ip()
{
    return $_SERVER['REMOTE_ADDR'];
}


function redirect($url)
{
    header("Location: $url");
    exit();
}


function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}


function is_admin()
{
    return isset($_SESSION['user_role']) && (int) $_SESSION['user_role'] === 1;
}



function require_login()
{
    if (!is_logged_in()) {
        $base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
            ? '/shoppn'
            : '/~raicha.ibrahim/E-commerce/shoppn';

        header('Location: ' . $base_path . '/views/login.php');
        exit();
    }
}


function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = 'You do not have permission to access this page.';

        $base_path = ($_SERVER['HTTP_HOST'] === 'localhost')
            ? '/shoppn'
            : '/~raicha.ibrahim/E-commerce/shoppn';

        header('Location: ' . $base_path . '/index.php');
        exit();
    }
}

?>
