<?php
session_start();
include 'config.php';

// Ensure user is a freelancer
if ($_SESSION['role'] != 'FREELANCER') {
    header('Location: dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch tickets assigned to this freelancer
$stmt = $conn->prepare("SELECT t.id, u.name AS customer_name, t.status, t.description 
                        FROM tickets t 
                        JOIN users u ON t.customer_id = u.id 
                        WHERE t.freelancer_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$tickets = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Tickets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Assigned Tickets</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Description</th
