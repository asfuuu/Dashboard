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

// Fetch brand names for dropdown
$brand_query = "SELECT brand_id, brand_name FROM brand";
$brand_result = $conn->query($brand_query);

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) { // Adding a product
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $brand_id = $conn->real_escape_string($_POST['brand_id']);
        $price = $conn->real_escape_string($_POST['price']);

        // Insert SQL
        $insert_sql = "INSERT INTO product (product_name, brand_id, price) VALUES ('$product_name', '$brand_id', '$price')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "New product added successfully";
        } else {
            echo "Error adding new product: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) { // Updating a product
        $product_id = $_POST['product_id'];
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $brand_id = $conn->real_escape_string($_POST['brand_id']);
        $price = $conn->real_escape_string($_POST['price']);

        // Update SQL
        $update_sql = "UPDATE product SET product_name='$product_name', brand_id='$brand_id', price='$price' WHERE product_id='$product_id'";

        if ($conn->query($update_sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) { // Deleting a product
        $product_id = $_POST['product_id'];

        // Delete SQL
        $delete_sql = "DELETE FROM product WHERE product_id='$product_id'";

        if ($conn->query($delete_sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Pagination settings
$results_per_page = 10;

// Fetch all products
$product_query = "SELECT product_id, product_name, brand_id, price FROM product";
$product_result = $conn->query($product_query);

// Count total products
$total_products = $product_result->num_rows;

// Calculate number of pages
$num_pages = ceil($total_products / $results_per_page);

// Check current page
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Calculate starting index for the query
$start_index = ($page - 1) * $results_per_page;

// Fetch products for the current page with limit and offset
$product_query_page = "SELECT product_id, product_name, brand_id, price FROM product LIMIT $start_index, $results_per_page";
$product_result_page = $conn->query($product_query_page);

?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php include 'check.php'; ?>
    <div class="content" id="content">
        <h2>Add Product</h2>
        <div class="col-md-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="product_name">
                </div>
                <div class="mb-3">
                    <label for="brandName" class="form-label">Brand Name</label>
                    <select class="form-select" id="brandName" name="brand_id">
                        <?php
                        if ($brand_result->num_rows > 0) {
                            while($row = $brand_result->fetch_assoc()) {
                                echo "<option value='" . $row["brand_id"] . "'>" . $row["brand_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Product Price</label>
                    <input type="text" class="form-control" id="productPrice" name="price">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
        <br>
        <hr>

        <h2>Product List</h2><br>
        <div class="container mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Brand Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($product_result_page->num_rows > 0) {
                        while($row = $product_result_page->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            // Fetch brand name for the product
                            $brand_id = $row["brand_id"];
                            $brand_query = "SELECT brand_name FROM brand WHERE brand_id='$brand_id'";
                            $brand_name_result = $conn->query($brand_query);
                            if ($brand_name_result && $brand_name_result->num_rows > 0) {
                                $brand_name_row = $brand_name_result->fetch_assoc();
                                echo "<td>" . $brand_name_row["brand_name"] . "</td>";
                            } else {
                                echo "<td>Brand not found</td>";
                            }
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_product.php?id=" . $row["product_id"] . "' class='btn btn-primary'>Edit</a>";
                            echo "<a href='product.php?delete=" . $row["product_id"] . "' class='btn btn-danger ms-2'>Delete</a>";
                            echo "<a href='view_product.php?id=" . $row["product_id"] . "' class='btn btn-info ms-2 text-white'>View</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $num_pages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>

</html>