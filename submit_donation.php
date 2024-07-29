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

// Check if form data is set
if (isset($_POST['donation_name']) && isset($_POST['donation_email']) && isset($_POST['donation_frequency']) && isset($_POST['donation_amount']) && isset($_POST['donation_payment_method'])) {
    // Retrieve form data
    $name = $_POST['donation_name'];
    $email = $_POST['donation_email'];
    $frequency = $_POST['donation_frequency'];
    $amount = isset($_POST['donation_amount']) && $_POST['donation_amount'] !== 'custom' ? $_POST['donation_amount'] : (isset($_POST['custom_amount']) ? $_POST['custom_amount'] : ''); // Use custom amount if provided
    $payment_method = $_POST['donation_payment_method'];
 
    if (empty($amount) || (!isset($_POST['donation_amount']) && empty($_POST['custom_amount']))) {
        die("Donation amount is required.");
    }
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO donors (name, email, amount, frequency, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $amount, $frequency, $payment_method);

    // Execute the query
    if ($stmt->execute()) {
        echo "Donation submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Missing form data.";
}

// Close the connection
$conn->close();
?>
