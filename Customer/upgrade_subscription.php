<?php
session_start();
include 'config.php';

// Ensure user is a customer
if ($_SESSION['role'] != 'CUSTOMER') {
    header('Location: dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current subscription
$stmt = $conn->prepare("SELECT * FROM subscriptions WHERE customer_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$current_subscription = $stmt->get_result()->fetch_assoc();

// Handle form submission for subscription upgrade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_plan = $_POST['plan'];

    // Update subscription plan in database
    if ($current_subscription) {
        $stmt = $conn->prepare("UPDATE subscriptions SET plan = ? WHERE customer_id = ?");
        $stmt->bind_param('si', $new_plan, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO subscriptions (customer_id, plan) VALUES (?, ?)");
        $stmt->bind_param('is', $user_id, $new_plan);
    }

    if ($stmt->execute()) {
        header('Location: manage_subscription.php');
    } else {
        $error = "Failed to update subscription!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upgrade Subscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3>Upgrade Subscription</h3>
    <form method="POST">
        <div class="form-group">
            <label>Select New Plan</label>
            <select name="plan" class="form-control" required>
                <option value="FREE" <?= $current_subscription['plan'] == 'FREE' ? 'selected' : '' ?>>Free</option>
                <option value="BASIC" <?= $current_subscription['plan'] == 'BASIC' ? 'selected' : '' ?>>Basic</option>
                <option value="GOLD" <?= $current_subscription['plan'] == 'GOLD' ? 'selected' : '' ?>>Gold</option>
                <option value="PREMIUM" <?= $current_subscription['plan'] == 'PREMIUM' ? 'selected' : '' ?>>Premium</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Upgrade Plan</button>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    </form>
</div>
</body>
</html>
