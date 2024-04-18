<?php
ini_set('display_startup_errors',1);
ini_set("display_errors", 1);
error_reporting(E_ALL);

//DUTCHVR settings: education@dutchvrviewer.com, admin_education, admin_education, 57vSI55H
$HOST      = 'localhost';   // HostName
$NAME      = 'admin_education';               // Database name
$USER      = 'admin_education';               // Database user ID
$PASSWORD  = '57vSI55H';                      // Database User Password
$CHARSET   = 'utf8mb4';

/*
$link = new mysqli(HOST, USER, PASSWORD, NAME);

if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
} */

// Create a database connection
$dsn = "mysql:host=$HOST;dbname=$NAME;charset=$CHARSET";

$options    = [
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      => false,
];

try {

    //Prepare connection and set the fetching method
    $pdo = new PDO($dsn, $USER, $PASSWORD, $options);
    echo "CONNECTED TO DATABASE\n";

} catch (\PDOException $e) {

    //If connection fails send error message when the connection dies
    throw new PDOException($e->getMessage(), (int)$e->getCode());
    echo "NO CONNECTION TO DATABASE";

}

$link = $pdo;

include "incl/classes.php";


?>