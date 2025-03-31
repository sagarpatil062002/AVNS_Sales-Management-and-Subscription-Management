<?php
session_start();
include 'config.php';

// Only Super Admin and Sub Admin can access
if ($_SESSION['role'] != 'SUPER_ADMIN' && $_SESSION['role'] != 'SUB_ADMIN') {
    header('Location: dashboard.php');
    exit;
}

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_products.php');
    exit;
}

$product_id = $_GET['id'];

// Attempt to delete the product record
$delete_product_sql = "DELETE FROM Product WHERE id = ?";
$stmt = $conn->prepare($delete_product_sql);
$stmt->bind_param('i', $product_id);

if ($stmt->execute()) {
    header('Location: manage_products.php');
} else {
    $error = "Failed to delete product! The product may be referenced in other records.";
    // Optionally, handle the error (e.g., display a message)
}
?>
