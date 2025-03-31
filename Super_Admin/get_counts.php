<?php
header('Content-Type: application/json');
include 'db_connection.php'; // Include the database connection

// Query to get total users
$sql_users = "SELECT COUNT(*) AS totalUsers FROM User";
$result_users = $conn->query($sql_users);
$totalUsers = $result_users->fetch_assoc()['totalUsers'];

// Query to get total products
$sql_products = "SELECT COUNT(*) AS totalProducts FROM Product";
$result_products = $conn->query($sql_products);
$totalProducts = $result_products->fetch_assoc()['totalProducts'];

// Close connection
$conn->close();

// Output as JSON
echo json_encode([
    'totalUsers' => $totalUsers,
    'totalProducts' => $totalProducts
]);
?>
