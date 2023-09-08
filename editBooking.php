<?php
require "connect.php"; 

// Fetch data from the database
if (!$mysqli->connect_errno) {
    $bID = $_POST['bID'];

    $stmt = $mysqli->prepare("SELECT * FROM booking WHERE bID = ?");
    $stmt->bind_param("i", $bID);
    $stmt->execute();
    $result = $stmt->get_result(); // Use $stmt to get the result

    if ($result !== false) {
        $count = $result->num_rows;

        if ($count == 1) {
            // Update the booking record based on bID (replace [value-1] with the actual bID)
            $stmt = $mysqli->prepare("UPDATE `booking` SET `uID`=?, `cID`=?, `uDateFrom`=?, `uDateTo`=? WHERE `bID`=?");
            $stmt->bind_param("iiiss", $uID, $cID, $uDateFrom, $uDateTo, $bID);
            $uID = $_POST['uID'];
            $cID = $_POST['cID'];
            $uDateFrom = $_POST['uDateFrom'];
            $uDateTo = $_POST['uDateTo'];
            $bID = $_POST['bID'];

            if ($stmt->execute()) {
                echo json_encode(array("success" => true, "message" => "Booking updated successfully"));
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to update booking"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Booking not found"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Query error"));
    }

    $stmt->close(); // Close the statement
} else {
    echo json_encode(array("success" => false, "message" => "Query error"));
}

$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
?>
