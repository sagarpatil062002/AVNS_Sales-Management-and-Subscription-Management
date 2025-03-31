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

// Get product ID from URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($product_id) {
    // Fetch product details based on product ID
    $sql = "SELECT * FROM Product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product is found
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid product ID!";
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product View - <?php echo $product['name']; ?></title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Product View */
        .product-view .product-name {
            font-size: 24px;
            color: #2874f0;
        }
        .product-view .label-stock {
            font-size: 13px;
            padding: 4px 13px;
            border-radius: 5px;
            color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
            float: right;
        }
        .product-view .product-path {
            font-size: 13px;
            font-weight: 500;
            color: #252525;
            margin-bottom: 16px;
        }
        .product-view .selling-price {
            font-size: 26px;
            color: #000;
            font-weight: 600;
            margin-right: 8px;
        }
        .product-view .btn1 {
            border: 1px solid;
            margin-right: 3px;
            border-radius: 0px;
            font-size: 14px;
            margin-top: 10px;
        }
        .product-view .btn1:hover {
            background-color: #2874f0;
            color: #fff;
        }
        .product-view .input-quantity {
            border: 1px solid #000;
            margin-right: 3px;
            font-size: 12px;
            margin-top: 10px;
            width: 58px;
            outline: none;
            text-align: center;
        }
        /* Product View */
    </style>
</head>
<body>

    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border">
                        <img src="<?php echo $product['images']; ?>" class="w-100" alt="<?php echo $product['name']; ?>">
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            <?php echo $product['name']; ?>
                        </h4>
                        <hr>
                        <p class="product-path">
                            Home / Category / Product / <?php echo $product['name']; ?>
                        </p>
                        <div>
                            <span class="selling-price">Part No: <?php echo $product['partNo']; ?></span>
                        </div>
                        <div>
                            <span class="selling-price">Model: <?php echo $product['model']; ?></span>
                        </div>
                        <div>
                            <span class="selling-price">HSN No: <?php echo $product['hsnNo']; ?></span>
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1"><i class="fa fa-minus"></i></span>
                                <input type="text" value="1" class="input-quantity" />
                                <span class="btn btn1"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</a>
                            <a href="wishlist.php?id=<?php echo $product['id']; ?>" class="btn btn1"> <i class="fa fa-heart"></i> Add To Wishlist </a>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0">Description</h5>
                            <p><?php echo $product['description']; ?></p>
                        </div>
                    </div>
                </div>
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
