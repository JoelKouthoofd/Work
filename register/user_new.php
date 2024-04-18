<?php

include_once "../config.php";
session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
          maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Registration</title>
</head>
<body style="text-align: center">

<h2>Student Toevoegen</h2>

<form action="user_handler.php" method="post">

    <p>
        <label for="student_number">Student Number:</label><br>
        <input type="number" name="student_number" id="student_number" required>
    </p>

    <p>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="student_number" required>
    </p>

    <p>
        <label for="password">Wachtwoord:</label><br>
        <input type="text" name="password" id="password" required>
    </p>

    <p>
        <label for="first_name">Voornaam:</label><br>
        <input type="text" name="first_name" id="first_name" required>
    </p>

    <p>
        <label for="last_name">Achternaam:</label><br>
        <input type="text" name="last_name" id="last_name" required>
    </p>

    <p>
        <label for="age">leeftijd:</label><br>
        <input type="number" name="age" id="age" required>
    </p>

    <p>
        <button onclick="history.back();return false;">Annuleren</button>
        <input type="submit" name="submit" id="submit" value="Aanmaken">
    </p>

</form>

</body>
</html>
