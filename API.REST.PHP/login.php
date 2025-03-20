<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// default user
$usuarios = [
    "admin@example.com" => "123456",
];

// if everything is ok ..
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // check the email and password
    if (isset($usuarios[$email]) && $usuarios[$email] === $password) {
        $_SESSION['user'] = $email;
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid_request";
}
?>