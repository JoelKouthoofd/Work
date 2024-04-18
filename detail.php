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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Detail Klas</title>
</head>
<body>

<?php

    //This page has to get changed


     //Read ID from url
     $class_id = $_GET['class_id'];

     //Read Class from database
     $result = mysqli_query($link, "SELECT * FROM couple_students_classes WHERE class_id = " . $class_id . " ORDER BY student_name DESC");

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
         echo "klas niet gevonden.<br>";
         echo "<a href='../index.php'>Ga terug</a>";
     }


?>

</body>
</html>
