<?php

require_once '../session.inc.php';
include '../config.php';

if (strlen($_SESSION['teacher_id']) > 0) {

    //Read ID from url
    $student_id = $_GET['student_id'];

    //Connect to the student
    $result = mysqli_query($link, "SELECT * FROM couple_students_classes WHERE student_id = " . $student_id);

    //If the student has been found proceed to delete him from the table
    if (mysqli_num_rows($result) == 1)
    {

        $delete = mysqli_query($link, "DELETE FROM couple_students_classes WHERE student_id = " . $student_id);

        //check if the student has been succesfully removed
        if($delete)
        {

            header("../detail.php");
        } else {

            echo "er is een fout opgetreden probeer het opnieuw<br>";
            echo "<a href='../detail.php'>Ga terug</a>";
        }
    }
}
