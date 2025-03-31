<?php
session_start();
include 'config.php';

// Ensure user is a customer
if ($_SESSION['role'] != 'CUSTOMER') {
    header('Location: dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch orders for this customer
$stmt = $conn->prepare("SELECT o.id, p.name, o.status, o.created_at 
                        FROM orders o 
                        JOIN products p ON o.product_id = p.id 
                        WHERE o.customer_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Your Orders</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['name'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
