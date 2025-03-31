<?php
session_start();
include 'config.php';

// Get user ID
$user_id = $_SESSION['user_id'];

// Fetch unread notifications
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$notifications = $stmt->get_result();

// Prepare notifications list
$response = [];
while ($notification = $notifications->fetch_assoc()) {
    $response[] = [
        'message' => $notification['message'],
        'created_at' => $notification['created_at']
    ];
}

// Mark notifications as read
$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();

// Return notifications as JSON
echo json_encode($response);
?>
