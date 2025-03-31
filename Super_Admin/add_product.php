<?php
session_start();
include 'config.php';

// Only Super Admin and Sub Admin can access
if ($_SESSION['role'] != 'SUPER_ADMIN' && $_SESSION['role'] != 'SUB_ADMIN') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $oemId = $_POST['oemId'];
    $categoryId = $_POST['categoryId'];
    $subcategories = json_encode(explode(',', $_POST['subcategories'])); // Handle subcategories as JSON
    $partNo = $_POST['partNo'];
    $model = $_POST['model'];
    $hsnNo = $_POST['hsnNo'];
    $datasheet = $_POST['datasheet'];
    
    // Handle file uploads
    $target_dir = "uploads/";
    $image_paths = [];
    
    foreach ($_FILES['images']['name'] as $key => $filename) {
        $target_file = $target_dir . basename($filename);
        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
            $image_paths[] = $target_file;  // Add the path of the uploaded image to the array
        } else {
            $error = "Failed to upload image!";
            break;
        }
    }

    // Store images as JSON in the database
    $images = json_encode($image_paths);

    if (!isset($error)) {
        // Prepare the SQL statement with all fields
        $stmt = $conn->prepare("INSERT INTO Product (name, description, oemId, categoryId, subcategories, partNo, model, hsnNo, images, datasheet) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssss', $name, $description, $oemId, $categoryId, $subcategories, $partNo, $model, $hsnNo, $images, $datasheet);
        
        if ($stmt->execute()) {
            header('Location: manage_products.php');
            exit;
        } else {
            $error = "Failed to add product!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* ===== Google Font Import - Poppins ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f4f4; /* Light gray background for the whole page */
        }
        .container {
            position: relative;
            max-width: 900px;
            width: 100%;
            border-radius: 6px;
            padding: 30px;
            margin: 0 15px;
            background-color: #fff; /* White background for the form */
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        .container header {
            position: relative;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }
        .container header::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            height: 3px;
            width: 27px;
            border-radius: 8px;
            background-color: #4070f4;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
        }
        .form-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #aaa;
            border-radius: 5px;
            font-size: 15px;
            color: #333;
            outline: none;
        }
        .form-input:focus {
            border-color: #4070f4;
        }
        textarea.form-input {
            resize: vertical;
            height: 150px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            background-color: #4070f4;
            cursor: pointer;
            transition: 0.3s ease;
        }
        button:hover {
            background-color: #265df2;
        }
        .alert {
            margin-top: 20px;
            padding: 10px;
            color: #fff;
            background-color: #f44336;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <header>Add New Product</header>
    <form method="POST">
        <div class="form-group">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-input" required>
        </div>
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-input" required></textarea>
        </div>
        <div class="form-group">
            <label class="form-label">OEM</label>
            <select name="oemId" class="form-input" required>
                <?php
                    // Fetch OEM options from the database
                    $oem_sql = "SELECT id, name FROM OEM";
                    $oem_result = $conn->query($oem_sql);
                    if ($oem_result->num_rows > 0) {
                        while ($oem_row = $oem_result->fetch_assoc()) {
                            echo "<option value='" . $oem_row['id'] . "'>" . $oem_row['name'] . "</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Category</label>
            <select name="categoryId" class="form-input" required>
                <?php
                    // Fetch category options from the database
                    $category_sql = "SELECT id, name FROM Category";
                    $category_result = $conn->query($category_sql);
                    if ($category_result->num_rows > 0) {
                        while ($category_row = $category_result->fetch_assoc()) {
                            echo "<option value='" . $category_row['id'] . "'>" . $category_row['name'] . "</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Subcategories (comma-separated)</label>
            <input type="text" name="subcategories" class="form-input" required>
        </div>
        <div class="form-group">
            <label class="form-label">Part Number</label>
            <input type="text" name="partNo" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">Model</label>
            <input type="text" name="model" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">HSN Number</label>
            <input type="text" name="hsnNo" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">Images (comma-separated URLs)</label>
            <input type="text" name="images" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">Datasheet (URL)</label>
            <input type="text" name="datasheet" class="form-input">
        </div>
        <button type="submit">Add Product</button>
        <?php if (isset($error)) echo "<div class='alert'>$error</div>"; ?>
    </form>
</div>
</body>
</html>
