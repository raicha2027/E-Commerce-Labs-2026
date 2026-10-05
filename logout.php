<?php

session_start();

session_unset();

session_destroy();


if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $base_path = '/shoppn';
} else {
    $base_path = '/~raicha.ibrahim/E-commerce/shoppn';
}


header('Location: ' . $base_path . '/index.php');

exit();

?>
