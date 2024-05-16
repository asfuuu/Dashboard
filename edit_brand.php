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

// Initialize $brandName
$brandName = "";

// Retrieve brand data if ID is provided
if (isset($_GET['id'])) {
    $brandID = sanitize_input($_GET['id']);
    $sql = "SELECT * FROM brand WHERE brand_id='$brandID'"; // Adjusted the column name here
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $brandName = $row['brand_name'];
    } else {
        echo "Brand not found.";
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Brand</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <h2>Edit Brand</h2>
        <form method="post" action="brand.php">
            <input type="hidden" name="brand_id" value="<?php echo isset($brandID) ? $brandID : ''; ?>">
            Brand Name: <input type="text" name="brand_name" value="<?php echo $brandName; ?>"><br><br>
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>

</html>