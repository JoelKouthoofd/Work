<?php

session_start();

include "config.php";
$userId = $_SESSION['UserID'];
$postToken = $_POST['token'];


if(isset($postToken)) {

    if ($postToken != $_SESSION['activitytoken']) {

        exit;
    }
    ActivityLogger::UpdateActivity($link, $userId, $postToken, $_SESSION['activityName']);

    echo json_encode(ActivityLogger::GetActivity($link, $userId));
}