<?php
session_start();
include 'config.php';

// Only Super Admin and Sub Admin can access
if ($_SESSION['role'] != 'SUPER_ADMIN' && $_SESSION['role'] != 'SUB_ADMIN') {
    header('Location: dashboard.php');
    exit;
}

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_products.php');
    exit;
}

$product_id = $_GET['id'];

// Fetch product details from the database
$product_sql = "SELECT * FROM Product WHERE id = ?";
$stmt = $conn->prepare($product_sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows == 0) {
    header('Location: manage_products.php');
    exit;
}

$product = $product_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $oemId = $_POST['oemId'];
    $categoryId = $_POST['categoryId'];
    $subcategories = json_encode($_POST['subcategories']);
    $partNo = $_POST['partNo'];
    $model = $_POST['model'];
    $hsnNo = $_POST['hsnNo'];
    $images = json_encode($_POST['images']);
    $datasheet = $_POST['datasheet'];
    $updatedAt = date('Y-m-d H:i:s');

    // Update product in the database
    $update_sql = "UPDATE Product SET name = ?, description = ?, oemId = ?, categoryId = ?, subcategories = ?, partNo = ?, model = ?, hsnNo = ?, images = ?, datasheet = ?, updatedAt = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('ssiiissssss', $name, $description, $oemId, $categoryId, $subcategories, $partNo, $model, $hsnNo, $images, $datasheet, $updatedAt, $product_id);
    
    if ($stmt->execute()) {
        $success = "Product updated successfully!";
    } else {
        $error = "Failed to update product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            background: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        .container header {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .container form .form-group {
            margin-bottom: 15px;
        }
        .container form .form-group label {
            font-weight: 500;
        }
        .container form .form-group input,
        .container form .form-group select,
        .container form .form-group textarea {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
        }
        .container form .form-group textarea {
            resize: vertical;
        }
        .btn {
            background-color: #4070f4;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #265df2;
        }
        .alert {
            padding: 15px;
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            border-radius: 5px;
            margin-top: 20px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
    </style>
</head>
<body>
<div class="container">
    <header>Edit Product</header>
    <?php if (isset($error)) echo "<div class='alert'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert success'>$success</div>"; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="oemId">OEM</label>
            <select id="oemId" name="oemId" required>
                <!-- Populate with options from OEM table -->
                <?php
                $oem_sql = "SELECT id, name FROM OEM";
                $oem_result = $conn->query($oem_sql);
                while ($oem = $oem_result->fetch_assoc()) {
                    $selected = $oem['id'] == $product['oemId'] ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($oem['id']) . "' $selected>" . htmlspecialchars($oem['name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="categoryId">Category</label>
            <select id="categoryId" name="categoryId" required>
                <!-- Populate with options from Category table -->
                <?php
                $category_sql = "SELECT id, name FROM Category";
                $category_result = $conn->query($category_sql);
                while ($category = $category_result->fetch_assoc()) {
                    $selected = $category['id'] == $product['categoryId'] ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($category['id']) . "' $selected>" . htmlspecialchars($category['name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategories">Subcategories (comma separated)</label>
            <input type="text" id="subcategories" name="subcategories" value="<?php echo htmlspecialchars(implode(', ', json_decode($product['subcategories'], true) ?? [])); ?>">
        </div>
        <div class="form-group">
            <label for="partNo">Part No</label>
            <input type="text" id="partNo" name="partNo" value="<?php echo htmlspecialchars($product['partNo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($product['model']); ?>" required>
        </div>
        <div class="form-group">
            <label for="hsnNo">HSN No</label>
            <input type="text" id="hsnNo" name="hsnNo" value="<?php echo htmlspecialchars($product['hsnNo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="images">Images (comma separated)</label>
            <input type="text" id="images" name="images" value="<?php echo htmlspecialchars(implode(', ', json_decode($product['images'], true) ?? [])); ?>">
        </div>
        <div class="form-group">
            <label for="datasheet">Datasheet URL</label>
            <input type="text" id="datasheet" name="datasheet" value="<?php echo htmlspecialchars($product['datasheet']); ?>" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Update Product</button>
        </div>
    </form>
</div>
</body>
</html>
