<?php
// config.php

$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP (empty password)
$dbname = "sales_management"; // Make sure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
