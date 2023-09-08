<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'cars';


$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

?>