<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aaa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product_id is set
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details
    $product_query = "SELECT product_id, product_name, brand_id FROM product WHERE product_id='$product_id'";
    $product_result = $conn->query($product_query);

    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row["product_name"];
        $brand_id = $product_row["brand_id"];

        // Fetch brand names for dropdown
        $brand_query = "SELECT brand_id, brand_name FROM brand";
        $brand_result = $conn->query($brand_query);

        // Display product details
        ?>
<!DOCTYPE html>
<html>

<head>
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <div class="container">
            <h2>Product Details</h2>
            <div class="card">
                <div class="card-body">
                    <p><strong>Product ID:</strong> <?php echo $product_id; ?></p>
                    <p><strong>Product Name:</strong> <?php echo $product_name; ?></p>
                    <?php
      // Fetch brand name for the product
      $brand_query = "SELECT brand_name FROM brand WHERE brand_id='$brand_id'";
      $brand_name_result = $conn->query($brand_query);
      if ($brand_name_result && $brand_name_result->num_rows > 0) {
          $brand_name_row = $brand_name_result->fetch_assoc();
          echo "<p><strong>Brand Name:</strong> " . $brand_name_row["brand_name"] . "</p>";
      } else {
          echo "<p><strong>Brand Name:</strong> Brand not found</p>";
      }
      ?>
                    <!-- Add to Cart form -->
                    <form method="post" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                        <input type="hidden" name="brand_name" value="<?php echo $brand_name_row['brand_name']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not specified";
}

$conn->close();
?>