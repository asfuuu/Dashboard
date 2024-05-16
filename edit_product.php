<?php
session_start();

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

        // Display edit form
        ?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <h2>Edit Product</h2>
        <form method="post" action="product.php">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            Product Name: <input type="text" name="product_name" value="<?php echo $product_name; ?>"><br><br>
            Brand Name:
            <select name="brand_id">
                <?php
                        if ($brand_result->num_rows > 0) {
                            while($row = $brand_result->fetch_assoc()) {
                                $selected = ($row["brand_id"] == $brand_id) ? "selected" : "";
                                echo "<option value='" . $row["brand_id"] . "' $selected>" . $row["brand_name"] . "</option>";
                            }
                        }
                        ?>
            </select><br><br>
            <input type="submit" name="update" value="Update">
        </form>
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