<?php
require "connect.php"; 

// Fetch data from the database
if (!$mysqli->connect_errno) {
    $bID = $_POST['bID'];

    $stmt = $mysqli->prepare("SELECT * FROM booking WHERE bID = ?");
    $stmt->bind_param("i", $bID); // Use "i" for binding an integer
    $stmt->execute();
    $result = $stmt->get_result(); // Use $stmt to get the result

    $data = [];

    if ($result->num_rows == 1) { // Use double equals for comparison
        while ($row = $result->fetch_assoc()) {
            $data = $row;
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
