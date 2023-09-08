<?php
require "connect.php"; 

// Fetch data from the database
if (!$mysqli->connect_errno) {
    $uID = $_POST['uID'];

    $stmt = $mysqli->prepare("SELECT * FROM booking WHERE uID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result(); // Use $stmt to get the result

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        // Handle the case where no rows are found
    }

    $stmt->close(); // Close the statement
} else {
    echo json_encode(array("success" => false, "message" => "Query error"));
}

$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
