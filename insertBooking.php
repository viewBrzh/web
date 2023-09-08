<?php
require "connect.php"; 

// Initialize response data
$response = array();

if (!$mysqli->connect_errno) {
    // Validate and sanitize input data
    $cID = isset($_POST['cID']) ? intval($_POST['cID']) : 0;
    $uID = isset($_POST['uID']) ? intval($_POST['uID']) : 0;
    $selectedFromDate = isset($_POST['from_date']) ? $_POST['from_date'] : '';
    $selectedToDate = isset($_POST['to_date']) ? $_POST['to_date'] : '';

    // Check if there are overlapping bookings for the selected car and date range
    $stmt = $mysqli->prepare("SELECT * FROM booking
    WHERE cID = ? AND ((uDateFrom BETWEEN ? AND ?) OR (uDateTo BETWEEN ? AND ?))");
    $stmt->bind_param("issss", $cID, $selectedFromDate, $selectedToDate, $selectedFromDate, $selectedToDate);
    $stmt->execute();
    $result = $stmt->get_result(); // Use $stmt to get the result

    if ($result !== false) {
        $count = $result->num_rows;

        if ($count == 0) {
            // No overlapping bookings, insert the new booking record
            $stmt = $mysqli->prepare("INSERT INTO `booking` (`cID`, `uID`, `uDateFrom`, `uDateTo`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $cID, $uID, $selectedFromDate, $selectedToDate);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Booking inserted successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to insert booking";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Car is already booked for the selected date range";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Query error: " . $mysqli->error; 
    }

    $stmt->close(); 
} else {
    $response['success'] = false;
    $response['message'] = "Database connection error: " . $mysqli->connect_error; 
}

$mysqli->close();

// Return data as JSON with appropriate HTTP status code
header('Content-Type: application/json');
http_response_code($response['success'] ? 200 : 400);
echo json_encode($response);
?>
