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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerId = $_POST['customerId'];
    $freelancerId = $_POST['freelancerId'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Ticket (customerId, freelancerId, status, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $customerId, $freelancerId, $status, $description);
    if ($stmt->execute()) {
        echo "Ticket created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Ticket</title>
</head>
<body>
    <h1>Create New Ticket</h1>
    <form method="post">
        <label for="customerId">Customer ID:</label>
        <input type="number" name="customerId" id="customerId" required><br>
        <label for="freelancerId">Freelancer ID:</label>
        <input type="number" name="freelancerId" id="freelancerId" required><br>
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="PENDING">PENDING</option>
            <option value="ASSIGNED">ASSIGNED</option>
            <option value="IN_PROGRESS">IN_PROGRESS</option>
            <option value="RESOLVED">RESOLVED</option>
            <option value="REJECTED">REJECTED</option>
        </select><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>
        <button type="submit">Create Ticket</button>
    </form>
</body>
</html>
<?php
// Close the connection
$conn->close();
?>
