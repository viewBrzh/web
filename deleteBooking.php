<?php
require "connect.php"; 

// Fetch data from the database
if (!$mysqli->connect_errno) {
    $bID = $_POST['bID'];

    $stmt = $mysqli->prepare("DELETE FROM booking WHERE bID = ?");
    $stmt->bind_param("i", $bID);
    $stmt->execute();
    $result = $stmt->get_result(); // Use $stmt to get the result

    $stmt->close(); // Close the statement
} else {
    echo json_encode(array("success" => false, "message" => "Query error"));
}

$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
?>
