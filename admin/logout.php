<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './includes/functions/functions.php';

$logout = new User();
$logout->logout();