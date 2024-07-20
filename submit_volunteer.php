<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "okoakd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$category = $_POST['category'];
$county = $_POST['county'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO volunteers (name, email, phone, category, county) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $category, $county);

// Execute the query
if ($stmt->execute()) {
  echo "New volunteer record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
