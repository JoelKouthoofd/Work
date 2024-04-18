<?php

// Normally this file is located outside of the http docs folder

// Disable showing errors in HTML Format
ini_set("html_errors", false);

// Different method (E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
$errors = error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING |
    E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
error_log($errors, 3, "error.log");

// Send all errors to the log file
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", "error.log");
ini_set("register_globals", 0);

// Configure base directory and disable file access through url
ini_set("open_basedir", "/education/");
ini_set("allow_url_fopen", 0);




