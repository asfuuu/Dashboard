<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "aaa";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Create operation
if (isset($_POST['submit'])) {
    $brandName = sanitize_input($_POST['brand_name']);
    $sql = "INSERT INTO brand (brand_name) VALUES ('$brandName')";
    if (mysqli_query($conn, $sql)) {
        echo "Brand added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Read operation
function getBrands() {
    global $conn;
    $sql = "SELECT * FROM brand";
    $result = mysqli_query($conn, $sql);
    $brands = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[] = $row;
        }
    }
    return $brands;
}

// Update operation
if (isset($_POST['update'])) {
    $brandID = sanitize_input($_POST['brand_id']);
    $brandName = sanitize_input($_POST['brand_name']);
    $sql = "UPDATE brand SET brand_name='$brandName' WHERE brand_id='$brandID'";
    if (mysqli_query($conn, $sql)) {
        echo "Brand updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Delete operation
if (isset($_GET['delete'])) {
    $brandID = sanitize_input($_GET['delete']);
    echo $brandID;
    $sql = "DELETE FROM brand WHERE brand_id='$brandID'";
    echo "SQL Query: " . $sql; // Debugging statement
    if (mysqli_query($conn, $sql)) {
        echo "Brand deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Read operation
$brands = getBrands();

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Brands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php include 'check.php'; ?>
    <div class="content" id="content">
        <h2>Add Brand</h2>
        <div class="col-md-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="brandNameInput" class="form-label">Brand Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="brandNameInput" name="brand_name">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>

        </div>
        <hr class="w-100 my-4">
        <br>
        <h2>Manage Brands</h2> <br>
        <?php if (!empty($brands)): ?>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
            // Pagination variables
            $results_per_page = 10;
            $number_of_pages = ceil(count($brands) / $results_per_page);

            // Check if page number is set, if not set to 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Calculate SQL LIMIT starting point
            $start_index = ($page - 1) * $results_per_page;

            // Slice brands array according to pagination
            $brands_slice = array_slice($brands, $start_index, $results_per_page);

            // Iterate through sliced brands
            foreach ($brands_slice as $brand): ?>
                    <tr>

                        <td><?php echo isset($brand['brand_id']) ? $brand['brand_id'] : ''; ?></td>
                        <td><?php echo isset($brand['brand_name']) ? $brand['brand_name'] : ''; ?></td>
                        <td>
                            <a href='edit_brand.php?id=<?php echo isset($brand['brand_id']) ? $brand['brand_id'] : ''; ?>'
                                class="btn btn-primary">Edit</a>
                            <a href='brand.php?delete=<?php echo isset($brand['brand_id']) ? $brand['brand_id'] : ''; ?>'
                                class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Pagination Links -->
            <ul class="pagination">
                <?php for ($i = 1; $i <= $number_of_pages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link"
                        href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
            </ul>
        </div>

        <?php else: ?>
        <p>No brands found.</p>
        <?php endif; ?>
    </div>
</body>

</html>