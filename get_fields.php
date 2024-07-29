<?php
include 'connect.php'; // Include the connection file

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    
    // Query to get column names
    $sql = "SHOW COLUMNS FROM $table";
    $result = $conn->query($sql);

    $fields = [];
    while ($row = $result->fetch_assoc()) {
        $fields[] = $row['Field'];
    }

    // Output column names as JSON
    header('Content-Type: application/json');
    echo json_encode($fields);
} else {
    echo json_encode([]);
}
?>
