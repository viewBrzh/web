<?php
require "connect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("php://input");

    if (isset($data) && !empty($data)) {
        $requestData = json_decode($data, true);

        if ($requestData !== null) {
        
            $oldEmail =  $requestData['oldEmail'];
            $newName = $requestData['newName'];
            $newEmail = $requestData['newEmail'];
            $newPassword = $requestData['newPassword'];

            if (!$mysqli->connect_errno) {
                // Update the user's name, email, and password
                $stmt = $mysqli->prepare("UPDATE user SET name = ?, email = ?, password = ? WHERE email = ?");
                $stmt->bind_param("ssss", $newName, $newEmail, $newPassword, $oldEmail);

                if ($stmt->execute()) {
                    echo json_encode(array("success" => true, "message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("success" => false, "message" => "Failed to update record"));
                }

                $stmt->close();
                $mysqli->close();
            } else {
                echo json_encode(array("success" => false, "message" => "Connection error"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Invalid JSON data"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "No data received"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>