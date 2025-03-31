<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $role = $_POST['role'] ?? '';
    $mobileNo = $_POST['mobileNo'] ?? ''; // Default to empty string if not set

    // Adjust the SQL statement to match the table name and structure
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, mobileNo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $name, $email, $password, $role, $mobileNo);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit(); // Ensure no further code is executed after redirect
    } else {
        $error = "Error in registration!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center">Register</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="CUSTOMER">Customer</option>
                        <option value="FREELANCER">Freelancer</option>
                        <option value="SUB_ADMIN">Sub Admin</option>
                        <option value="SUPER_ADMIN">Super Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mobile No</label>
                    <input type="text" name="mobileNo" class="form-control" required>
                </div>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
