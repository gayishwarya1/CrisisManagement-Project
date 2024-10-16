<?php
// Database configuration
$user = 'root';
$password = '';
$database = 'crisismanagement1';
$servername = 'localhost';
$port = 3306;

// Create connection
$mysqli = new mysqli($servername, $user, $password, $database, $port);

// Check connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

?>