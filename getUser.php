<?php
require "connect.php"; 

if (!$mysqli->connect_errno) {
    $uID = $_POST['uID'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE uID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        // Fetch the user data as an associative array
        $user = $result->fetch_assoc();
    
        if ($user) {
            // Do something with the user data, for example, print it as JSON
            echo json_encode(array("success" => true, "user" => $user));
        } else {
            // User with the specified uID not found
            echo json_encode(array("success" => false, "message" => "User not found"));
        }
    } else {
        // Error occurred during the query
        echo json_encode(array("success" => false, "message" => "Database error"));
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo json_encode(array("success" => false, "message" => "Connection error"));
}
?>