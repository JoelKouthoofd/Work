<?php

session_start();
// include "../incl/session.inc.php";
include "../config.php";

// Preparing Databasea
$stmt = $link->prepare('SELECT * FROM users');
$stmt->execute();

// Only returns the associative array - in this instance, everything

if (isset($_POST['email'])) {

    $studentNumber  = $_POST['student_number'];
    $userMail       = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $userPass       = $_POST['password'];
    $password       = password_hash($userPass, PASSWORD_DEFAULT);
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name'];
    $age            = $_POST['age'];
    $level          = 0;

    $newUser    = User::createUser($link, $studentNumber, $first_name, $last_name, $password, $age, $userMail, $level);

    echo json_encode($newUser);
}

$stmt->closeCursor();