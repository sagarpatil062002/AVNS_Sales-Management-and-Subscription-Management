<?php
session_start();
include 'config.php';

// Ensure sub-admin access
if ($_SESSION['role'] != 'SUB_ADMIN') {
    header('Location: dashboard.php');
    exit;
}

// Fetch all orders
$stmt = $conn->prepare("SELECT o.id, u.name as customer_name, p.name as product_name, o.status, o.created_at 
                        FROM orders o 
                        JOIN users u ON o.customer_id = u.id 
                        JOIN products p ON o.product_id = p.id 
                        ORDER BY o.created_at DESC");
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Manage Orders</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['customer_name'] ?></td>
                    <td><?= $order['product_name'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <a href="update_order_status.php?id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">Update Status</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
