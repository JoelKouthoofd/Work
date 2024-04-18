<?php

include '../config.php'

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Log-in</title>
</head>
<body style="text-align: center;">

<h2>Inloggen</h2>

<form action="login_handler.php" method="post">

    <p>
        <label for="email">Email:</label><br>
        <input type="text" name="email" id="email" required>
    </p>

    <p>
        <label for="password">Wachtwoord:</label><br>
        <input type="password" name="password" id="password" required>
    </p>

    <p>
        <button onclick="history.back();return false;">Annuleren</button>
        <input type="submit" name="submit" id="submit" value="Inloggen">
    </p>

</form>

</body>
</html>
