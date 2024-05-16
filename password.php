<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aaa"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// if (isset($_POST['oldPassword'])) {
//     $oldPassword = $_POST['oldPassword'];
//     $user_id = $_SESSION['user_id'];
    
//     // Perform a query to fetch the old password of the user from the database
//     $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result($storedPassword);
//     $stmt->fetch();
//     $stmt->close();


//     // Compare the hashed password entered by the user with the one stored in the database
//     if (password_verify($oldPassword, $storedPassword)) {
//         echo "true";
//     } else {
//         echo "false";
//     }
// }


if (isset($_POST['oldPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $user_id = $_SESSION['user_id'];
    
    // Perform a query to fetch the old password of the user from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Compare the hashed password entered by the user with the one stored in the database
    if (password_verify($oldPassword, $storedPassword)) {
        // If new password is provided, update the password in the database
        if (isset($_POST['newPassword'])) {
            $newPassword = $_POST['newPassword'];
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $hashedPassword, $user_id);
            if ($stmt->execute()) {
                echo "true";
            } else {
                echo "false";
            }
            $stmt->close();
        } else {
            // If new password is not provided, return true indicating old password match
            echo "true";
        }
    } else {
        echo "false";
    }
}

// Close the database connection
$conn->close();
?>