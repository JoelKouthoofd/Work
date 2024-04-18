<?php

session_start();
include "config.php";


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overview Pagina</title>
    <link href="main.css" rel="stylesheet"  type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>

<div class="container-lg">

    <?php

    /*
    if (strlen($_SESSION['student_id']) > 0 || $_SESSION['teacher_id'] > 0 || $_SESSION['school_id'] > 0 || $_SESSION['master_id']) {

        echo "U bent ingelogd als<strong>" .    $_SESSION['user']   .   "</strong><br>";

    }
*/

    ?>


    <button type="button" class="btn btn-outline-success" style="margin: 1.5rem 0rem 2.5rem 0rem" onclick="document.location = 'login/login.php'">Inloggen</button>
    <button type="button" class="btn btn-outline-secondary" style="margin: 1.5rem 0rem 2.5rem 0rem" onclick="document.location = 'login/logout.php'">Uitloggen</button>
    <button type="button" class="btn btn-outline-warning" style="margin: 1.5rem 0rem 2.5rem 0rem" onclick="document.location = 'register/user_new.php'">Register Student</button>

    <a href="detail.php"></a>

    <h2>Klassen</h2>



    <?php

    //leraar, school, admin moet studenten aan kunnen maken via register
    //If the user is a teacher create a list with his classes


        $stmt = $link->prepare("SELECT * FROM users WHERE level = 0");
        $stmt->execute();

        echo "<h3>Students</h3>";
        echo "<table class='table table-dark'>";

        //Create upper line sectioning data
        echo "<tr>";
        echo "<th scope='col'>Studentnumber</th>";
        echo "<th scope='col'>First Name</th>";
        echo "<th scope='col'>Last Name</th>";
        echo "<th scope='col'>Age</th>";
        echo "<th scope='col'>Email</th>";
        echo "<th scope='col'>Detail</th>";
        echo "<th scope='col'>Edit</th>";
        echo "<th scope='col'>Delete</th>";
        echo "</tr>";

        //Showcase each student
        while ($row = $stmt->fetch()) {

            echo "<tr>";
            echo "<td>" .   $row['student_number']  .   "</td>";
            echo "<td>" .   $row['first_name']      .   "</td>";
            echo "<td>" .   $row['last_name']       .   "</td>";
            echo "<td>" .   $row['age']             .   "</td>";
            echo "<td>" .   $row['email']           .   "</td>";

            echo "<td><a href='student/student_detail.php?id="  .   $row['user_id']  .   "'>detail</a></td>";
            echo "<td><a href='student/student_edit.php?id="    .   $row['user_id']  .   "'>edit</a></td>";
            echo "<td><a href='student/student_remove.php"      .   $row['user_id']  .   "'>Remove</a></td>";
            echo "</tr>";
        }

        $stmt->closeCursor();
        echo "</table>";

    //If the user is a student display his class
  /*  if (strlen($_SESSION['student_id']) > 0) {

        $result = mysqli_query($link, "SELECT * FROM couple_students_classes WHERE student_id = " . $_SESSION['student_id'] . " ORDER BY class_id");

        //create table
        echo "<table class='table table-dark'>";

        //Upper line with data
        echo "<tr>";
        echo "<th scope='col'>Klas</th>";
        echo "<th scope='col'>Leerlingnummer</th>";
        echo "<th scope='col'>naam</th>";
        echo "<th scope='col'>leeftijd</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($result)) {

            echo "<tr>";

            echo "<td>" . $row['class_name']    .  "</td>";
            echo "<td>" . $row['student_id']    .  "</td>";
            echo "<td>" . $row['name']          .  "</td>";
            echo "<td>" . $row['age']           .  "</td>";

            echo "</tr>";
        }

        echo "</table>";
    }

    //If the user is the school account
    if (strlen($_SESSION['school_id']) > 0) {

        $teacher_result = mysqli_query($link, "SELECT * FROM couple_teachers_classes ORDER BY NAME DESC");
        $class_result   = mysqli_query($link, "SELECT * FROM couple_teachers_classes ORDER BY NAME DESC");
        $student_result = mysqli_query($link, "SELECT * FROM students ORDER BY NAME DESC");

        //create table with teachers
        echo "<h3>Teachers</h3>";

        echo "<table class='table table-dark>'";

        echo "<tr>";
        echo "<th scope='col'>Naam</th>";
        echo "<th scope='col'>Leeftijd</th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";
        echo "</tr>";

        //showcase data off teacher
        while ($row = mysqli_fetch_array($teacher_result)) {

            $result = mysqli_query($link, "SELECT * FROM teachers");

            echo "<tr>";
            echo "<td>" .   $row['name']    .   "</td>";
            echo "<td>" .   $row['age']     .   "</td>";
            echo "<td><a href='teacher/detail.php?id="          . $row['teacher_id']    .   "'>Detail Teacher</td>";

            // Edit and remove teacher
            echo "<td><a href='teacher/teacher_edit.php?id="    . $row['teacher_id']    .   "'>Edit</a></td>";
            echo "<td><a href='teacher/teacher_remove.php?id="  . $row['teacher_id']    .   "'>Remove</a></td>";

            echo "</tr>";
        }
        echo "</table>";

        //Create table with classes
        echo "<h3>Classes</h3>";

        echo "<table class='table table-dark'>";

        echo "<tr>";
        echo "<th scope='col'>Class</th>";
        echo "<th scope='col'>Leraar</th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";
        echo "</tr>";

        //showcase class data
        while ($row = mysqli_fetch_array($class_result)) {

            echo "<tr>";
            echo "<td>" .   $row['class']   .   "</td>";
            echo "<td>" .   $row['teacher'] .   "</td>";

            echo "<td><a href='school/classes_detail.php?id="   .   $row['class_id']    .   "'>Detail</a></td>";
            echo "<td><a href='school/classes_edit.php?id="     .   $row['class_id']    .   "'>Edit</a></td>";
            echo "<td><a href='school/classes_remove.php?id="   .   $row['class_id']    .   "'>Remove</a></td>";
            echo "</tr>";
        }
        echo "</table>";


        //Create table with students
        echo "<h3>Students</h3>";
        echo "<table class='table table-dark'>";

        //Create upper line sectioning data
        echo "<tr>";
        echo "<th scope='col'>Studentnumber</th>";
        echo "<th scope='col'>First Name</th>";
        echo "<th scope='col'>Last Name</th>";
        echo "<th scope='col'>Email</th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";
        echo "<th scope='col'></th>";

        //Showcase each student
        while ($row = mysqli_fetch_array($student_result)) {

            echo "<tr>";
            echo "<td>" .   $row['student_id']  .   "</td>";
            echo "<td>" .   $row['first_name']  .   "</td>";
            echo "<td>" .   $row['last_name']   .   "</td>";
            echo "<td>" .   $row['email']       .   "</td>";

            echo "<td><a href='student/student_detail.php?id="  .   $row['student_id']  .   "'>detail</a></td>";
            echo "<td><a href='student/student_edit.php?id="    .   $row['student_id']  .   "'>edit</a></td>";
            echo "<td><a href='student/student_remove.php"      .   $row['student_id']  .   "'>Remove</a></td>";
        }
        echo "</table>";
    } */


    ?>

</div>
</body>
</html>


