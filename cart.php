<?php
session_start(); // Start session if not already started

// Check if Add to Cart button is clicked
if(isset($_POST['add_to_cart'])) {
    // Get product details from the form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $brand_name = $_POST['brand_name'];

    // Store product details in session or database as needed
    $_SESSION['cart'][] = array(
        'product_id' => $product_id,
        'product_name' => $product_name,
        'brand_name' => $brand_name
    );

    // Redirect back to product details page or any other page
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <div class="container">
            <h2>Cart</h2>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php
        // Check if there are items in the cart
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $item) {
                echo "<p><strong>Product ID:</strong> " . $item['product_id'] . "</p>";
                echo "<p><strong>Product Name:</strong> " . $item['product_name'] . "</p>";
                echo "<p><strong>Brand Name:</strong> " . $item['brand_name'] . "</p>";
                echo "<hr>";
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>