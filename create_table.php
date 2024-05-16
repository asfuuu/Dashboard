<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aaa";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($conn->query($sql) === TRUE) {
    echo "Table products_users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>