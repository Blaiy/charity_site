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

// Handle file upload
$cv_file = $_FILES['cv_file']['name'];
$cv_file_tmp = $_FILES['cv_file']['tmp_name'];
$cv_file_dir = 'uploads/' . $cv_file;

// Create the uploads directory if it doesn't exist
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if (move_uploaded_file($cv_file_tmp, $cv_file_dir)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO volunteers (name, email, phone, category, county, cv_file) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $category, $county, $cv_file);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error uploading file";
}


// Close the connection
$conn->close();
?>
