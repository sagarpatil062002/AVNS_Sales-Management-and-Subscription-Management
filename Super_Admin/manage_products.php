<?php
session_start();
include 'config.php';

// Only Super Admin and Sub Admin can access
if ($_SESSION['role'] != 'SUPER_ADMIN' && $_SESSION['role'] != 'SUB_ADMIN') {
    header('Location: dashboard.php');
    exit;
}

// Fetch products from the database
$product_sql = "SELECT p.*, o.name AS oemName, c.name AS categoryName FROM Product p
                JOIN OEM o ON p.oemId = o.id
                JOIN Category c ON p.categoryId = c.id";
$product_result = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
            background: #f4f4f4; /* Light gray background for the whole page */
        }
        .container {
            position: relative;
            max-width: 1500px; /* Increased max-width of the container */
            width: 100%;
            border-radius: 6px;
            padding: 30px;
            margin: 15px auto; /* Reduced margin to make the container larger */
            background-color: #fff; /* White background for the form */
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            overflow-x: auto; /* Allows horizontal scrolling if the table is too wide */
            min-height: 700px; /* Increased minimum height of the container */
        }
        .container header {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
            white-space: nowrap; /* Prevents text wrapping within cells */
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            color: #4070f4;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn {
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            background-color: #4070f4;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
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
    </style>
</head>
<body>
<div class="container">
    <header>
        <span>Manage Products</span>
        <a href="add_product.php" class="btn">Add New Product</a>
    </header>
    <?php if (isset($error)) echo "<div class='alert'>$error</div>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>OEM</th>
                <th>Category</th>
                <th>Subcategories</th>
                <th>Part No</th>
                <th>Model</th>
                <th>HSN No</th>
                <th>Images</th>
                <th>Datasheet</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($product_result->num_rows > 0) {
                while ($row = $product_result->fetch_assoc()) {
                    // Convert JSON encoded fields back to arrays
                    $subcategories = json_decode($row['subcategories'], true) ?? [];
                    $images = json_decode($row['images'], true) ?? [];
                    
                    // Use implode() to convert arrays to comma-separated strings
                    $subcategories_str = implode(', ', $subcategories);
                    $images_str = implode(', ', $images);

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['oemName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
                    echo "<td>" . htmlspecialchars($subcategories_str) . "</td>";
                    echo "<td>" . htmlspecialchars($row['partNo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['model']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hsnNo']) . "</td>";
                    echo "<td>" . htmlspecialchars($images_str) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row['datasheet']) . "'>View</a></td>";
                    echo "<td>" . htmlspecialchars($row['createdAt']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['updatedAt']) . "</td>";
                    echo "<td><a href='edit_product.php?id=" . htmlspecialchars($row['id']) . "' class='btn'>Edit</a> 
                              <a href='delete_product.php?id=" . htmlspecialchars($row['id']) . "' class='btn' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>No products found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
