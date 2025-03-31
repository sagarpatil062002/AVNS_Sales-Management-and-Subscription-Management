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

// Fetch all products
$sql = "SELECT * FROM Product"; 
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Our Products</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Product Card */
    .product-card {
        background-color: #fff;
        border: 1px solid #ccc;
        margin-bottom: 24px;
    }
    .product-card a {
        text-decoration: none;
    }
    .product-card .stock {
        position: absolute;
        color: #fff;
        border-radius: 4px;
        padding: 2px 12px;
        margin: 8px;
        font-size: 12px;
    }
    .product-card .product-card-img {
        max-height: 260px;
        overflow: hidden;
        border-bottom: 1px solid #ccc;
    }
    .product-card .product-card-img img {
        width: 100%;
    }
    .product-card .product-card-body {
        padding: 10px 10px;
    }
    .product-card .product-card-body .product-name {
        font-size: 20px;
        font-weight: 600;
        color: #000;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .product-card .product-card-body .btn1 {
        border: 1px solid;
        margin-right: 3px;
        border-radius: 0px;
        font-size: 12px;
        margin-top: 10px;
    }
    /* Product Card End */
    </style>
</head>
<body>

<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Our Products</h4>
            </div>

            <!-- Fetch products from the database -->
            <?php while ($product = $result->fetch_assoc()) { ?>
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-card-img">
                            <img src="<?php echo $product['images']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-name">
                               <a href="view_product.php?id=<?php echo $product['id']; ?>">
                                    <?php echo $product['name']; ?>
                               </a>
                            </h5>
                            <p>Part No: <?php echo $product['partNo']; ?></p>
                            <p>Model: <?php echo $product['model']; ?></p>
                            <p>HSN No: <?php echo $product['hsnNo']; ?></p>
                            <div class="mt-2">
                                <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn1">Add To Cart</a>
                                <a href="wishlist.php?id=<?php echo $product['id']; ?>" class="btn btn1"><i class="fa fa-heart"></i></a>
                                <a href="view_product.php?id=<?php echo $product['id']; ?>" class="btn btn1"> View </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
