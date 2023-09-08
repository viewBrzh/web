<?php
require "connect.php"; 

if (!$mysqli->connect_errno) {
    $uTelephone = $_POST['uTelephone'];
    $uPassword = $_POST['uPassword'];
    $uName = $_POST['uName'];
    $cPassword = $_POST['cPassword'];

    if ($uPassword != $cPassword) {
        echo json_encode(array("success" => false, "message" => "Password and Confirm Password doesn't match!"));
        exit;
    }

    $stmt = $mysqli->prepare("SELECT uTelephone FROM users WHERE uTelephone = ?");
    $stmt->bind_param("s", $uTelephone);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result !== false) {
        $count = $result->num_rows;
        
        if ($count == 1) {
            echo json_encode(array("success" => false, "message" => "Telephone number has been used"));
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users (uTelephone , uPassword , uName) VALUE (?, ?, ?)");
            $stmt->bind_param("sss", $uTelephone, $uPassword, $uName);
            $stmt->execute();
            echo json_encode(array("success" => true, "message" => "Registration successfully"));
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
