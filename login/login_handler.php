<?php

session_start();
include '../config.php';

$email      = $_POST['email'];
$password   = $_POST['password'];

$stmt = $link->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
$stmt->execute();

if (isset($_POST['submit'])) {

    if ($_POST['email'] == "" || $_POST['password'] == "") {
        echo "<script>showAlert('warning', 'please enter your credentials')</script>";

    } else {

        $user = User::findUserByName($link, $_POST['email']);

        if ($user) {

            if ($user->loginUser($link, $_POST['password'])) {

                $_SESSION['userId'] = $user->getId();

                $token = $user->makeUserToken($link);

                $_SESSION['LoginToken'] = $token;
                echo "<script>showAlert('warming', 'You have been logged in!')</script>";

            } else {

                echo "<script>showAlert('warning', 'Email or password is incorrect');</script>";
            }
        }
    }
}
