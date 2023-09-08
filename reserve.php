<?php
require "connect.php"; 

if (!$mysqli->connect_errno) {
    $uID = $_POST['uID'];
    $cID = $_POST['cID'];
    $uDateFrom = $_POST['uDateFrom'];
    $uDateTo = $_POST['uDateTo'];

    try {
        // Check if the user and book exist
        $dateFrom = strtotime($uDateFrom);
        $dateTo = strtotime($uDateTo);
        $userQuery = $mysqli->prepare('SELECT * FROM users WHERE uID = ?');
        $userQuery->bind_param('i', $uID);
        $userQuery->execute();
        $userResult = $userQuery->get_result();
        $user = $userResult->fetch_assoc();

        $bookQuery = $mysqli->prepare('SELECT * FROM cars WHERE cID = ?');
        $bookQuery->bind_param('i', $cID);
        $bookQuery->execute();
        $bookResult = $bookQuery->get_result();
        $book = $bookResult->fetch_assoc();

        if (!$user || !$book) {
            http_response_code(404);
            echo json_encode(array('error' => 'User or book not found'));
            exit;
        }

        // Insert the book into the user's favorites
        $insertQuery = $mysqli->prepare('INSERT INTO booking (uID, cID, uDateFrom, uDateTo) VALUES (?, ?, ?, ?)');
        $insertQuery->bind_param('iiii', $uiD, $cID, $dateFrom, $dateTo);
        $insertQuery->execute();

        echo json_encode(array('message' => 'Book added to favorites'));
    } catch (PDOException $error) {
        error_log('Error adding book to favorites: ' . $error->getMessage());
        http_response_code(500);
        echo json_encode(array('error' => 'Internal server error'));
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo json_encode(array("success" => false, "message" => "Connection error"));
}
?>