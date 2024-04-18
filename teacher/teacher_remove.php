<?php

require_once '../session.inc.php';
include '../config.php';
session_start();

if (strlen($_SESSION['school_id'] || $_SESSION['admin_id'])) {

    //Read ID from url
    $teacher_id = $_GET['teacher_id'];

    //Connect to the student
    $result = mysqli_query($link, "SELECT * FROM teachers WHERE teacher_id = " . $teacher_id);

    //If the student has been found proceed to delete him from the table
    if (mysqli_num_rows($result) == 1)
    {

        $delete = mysqli_query($link, "DELETE FROM teachers WHERE teacher_id = " . $teacher_id);

        //check if the student has been succesfully removed
        if($delete)
        {

            header("../index.php");
        } else {

            echo "er is een fout opgetreden probeer het opnieuw<br>";
            echo "<a href='../detail.php'>Ga terug</a>";
        }
    }
}
