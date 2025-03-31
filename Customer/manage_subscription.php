<?php
session_start();
include 'config.php';

// Ensure user is a customer
if ($_SESSION['role'] != 'CUSTOMER') {
    header('Location: dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch subscription details
$stmt = $conn->prepare("SELECT * FROM subscriptions WHERE customer_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$subscription = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Subscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Your Subscription</h3>
    <?php if ($subscription): ?>
        <p>Plan: <?= $subscription['plan'] ?></p>
        <p>Reward Points: <?= $subscription['reward_points'] ?></p>
        <a href="upgrade_subscription.php" class="btn btn-primary">Upgrade Plan</a>
    <?php else: ?>
        <p>No active subscription. <a href="choose_plan.php" class="btn btn-primary">Choose a Plan</a></p>
    <?php endif; ?>
</div>
</body>
</html>
