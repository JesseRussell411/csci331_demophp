<?php
$dbhost  = 'localhost';

$dbname  = 'db60';   // Modify these...
$dbuser  = 'user60';   // ...variables according
$dbpass  = '60mice';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) 
    throw new Exception("Cannot connect to database");

// tell mysqli to throw errors
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ERROR;
?>