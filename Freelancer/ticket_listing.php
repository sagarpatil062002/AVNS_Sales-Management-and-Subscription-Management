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

// Fetch all tickets
$sql = "SELECT * FROM Ticket";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tickets</title>
</head>
<body>
    <h1>Manage Tickets</h1>
    <a href="create_ticket.php">Create New Ticket</a>
    <table border="1">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($ticket['id']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['description']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['status']); ?></td>
                    <td>
                        <a href="ticket_detail.php?id=<?php echo htmlspecialchars($ticket['id']); ?>">View Details</a>
                        <a href="edit_ticket.php?id=<?php echo htmlspecialchars($ticket['id']); ?>">Edit</a>
                        <a href="delete_ticket.php?id=<?php echo htmlspecialchars($ticket['id']); ?>" onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Close the connection
$conn->close();
?>
