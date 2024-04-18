<?php

include "config.php";
include_once "session.inc.php";
session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Klas</title>
</head>
<body>

<?php

if (strlen($_SESSION['teacher_id'] > 0 || $_SESSION['school_id'] > 0)) {

//Read ID from url
$student_id = $_GET['student_id'];

//Read Class from database
$result = mysqli_query($link, "SELECT * FROM students WHERE class_id = " . $student_id);

//Display the class
if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_array($result);

    //Create table
    echo "<table class='table table-dark'>";

    //Create rows for students
    echo "<tr>";
    echo "<th scope='col'>klas</th>";
    echo "<th scope='col'>leerlingnummer</th>";
    echo "<th scope='col'>naam</th>";
    echo "<th scope='col'>leeftijd</th>";
    echo "<th scope='col'></th>";
    echo "<th scope='col'></th>";
    echo "</tr>";

    echo "</table>";

    // Student data
    echo "<tr>";
    echo "<td>" . $row['class_id']                 .  "</td>";
    echo "<td>" . $row['student_id']               .  "</td>";
    echo "<td>" . $row['student_first_name']       . " " . $row['student_last_name'] . "</td>";
    echo "<td>" . $row['student_id']               .  "</td>";

    //Enable management of students
    echo "<td><a href='student/remove.php?id=" . $row['student_id'] . "'>verwijderen</td>";
    echo "</tr>";

    } else {

    //send user back if the class can't be found
    echo "Leerling niet gevonden.<br>";
    echo "<a href='../index.php'>Ga terug</a>";
    }


}


?>

</body>
</html>
