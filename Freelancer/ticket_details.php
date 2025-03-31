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

// Check if 'id' parameter is set
if (isset($_GET['id'])) {
    $ticket_id = $_GET['id'];

    // Fetch ticket details
    $sql = "SELECT * FROM Ticket WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
    } else {
        echo "No ticket found";
    }
} else {
    echo "No ticket ID specified";
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Details</title>
</head>
<body>
    <h1>Ticket Details</h1>
    <?php if (isset($ticket)) { ?>
        <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket['id']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($ticket['description']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($ticket['status']); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($ticket['createdAt']); ?></p>
        <p><strong>Updated At:</strong> <?php echo htmlspecialchars($ticket['updatedAt']); ?></p>
    <?php } ?>
</body>
</html>
