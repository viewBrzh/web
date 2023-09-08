<?php
require "connect.php"; 

// Fetch data from the database
$sql = "SELECT * FROM cars";
$result = $mysqli->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
