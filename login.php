<?php
require "connect.php"; 

if (!$mysqli->connect_errno) {
    $uTelephone = $_POST['uTelephone'];
    $uPassword = $_POST['uPassword'];

    $stmt = $mysqli->prepare("SELECT uID, uTelephone, uName FROM users WHERE uTelephone = ? AND uPassword = ?");
    $stmt->bind_param("ss", $uTelephone, $uPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false) {
        $count = $result->num_rows;
        
        if ($count == 1) {
            $user = $result->fetch_assoc();
            $user_id = $user['uID'];
            $user_telephone = $user['uTelephone'];
            $user_name = $user['uName'];
            echo json_encode(array("success" => true, "message" => "Login successful", "id" => $user_id, "telephone" => $user_telephone, "name" => $user_name));
        } else {
            echo json_encode(array("success" => false, "message" => "Incorrect Telephone number or Password"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Query error"));
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo json_encode(array("success" => false, "message" => "Connection error"));
}
?>
