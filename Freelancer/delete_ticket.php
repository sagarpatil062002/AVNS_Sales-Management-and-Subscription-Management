<?php
// Database connection (replace with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "sales_management";

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Ticket WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Ticket deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "No ticket ID specified";
}

// Close the connection
$conn->close();
?>
