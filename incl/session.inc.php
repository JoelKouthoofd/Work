<?php

require_once "../config.php";
session_start();

if (!isset($_SESSION['student_id']) || !isset($_SESSION['teacher_id']) == 0 || !isset($_SESSION['school_id']) == 0) {

    //Send them back to the index for being on the wrong page
    header("location:../index.php");
}