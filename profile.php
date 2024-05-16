<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or handle the case where the user is not logged in
    header("Location: login.php");
    exit(); // Stop further execution
}
$username=$_SESSION['username'] ;
$user_id=$_SESSION['user_id'] ;
$firstname=$_SESSION['firstname'] ;
$lastname=$_SESSION['lastname'] ;


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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}
</style>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="content" id="content">
        <h1>welcome to profile page</h1>
        <div class="row">
            <div class="col-md-6">
                <p class="fw-bold">Username:</p>
                <p><?php echo $username; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="fw-bold">First Name:</p>
                <p><?php echo $firstname; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="fw-bold">Last Name:</p>
                <p><?php echo $lastname; ?></p>
            </div>
        </div>

        <div class="container mt-5">
            <form id="changePasswordForm">
                <h2 class="mb-4">Password</h2>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password:</label>
                        <span id="oldPasswordError" class="text-danger"></span>
                        <input type="password" id="oldPassword" name="oldPassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password:</label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password:</label>
                        <span id="confirmPasswordError" class="text-danger"></span>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
        <div id="message" style="display:none;"></div>

    </div>
    <script>
    $(document).ready(function() {
        // Function to check if old password matches with the one in the database
        $("#oldPassword").keyup(function() {
            var oldPassword = $(this).val();
            $.ajax({
                url: 'password.php',
                type: 'post',
                data: {
                    oldPassword: oldPassword
                },
                success: function(response) {
                    console.log('data: ', response);
                    // Response will contain either 'true' or 'false'
                    if (response.trim() == "false") {
                        $('#oldPasswordError').text('Incorrect old password.');
                    } else {
                        $('#oldPasswordError').text('');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // This function will be executed if the request fails
                    console.log("Error:", textStatus, errorThrown);
                    // You can handle the error here, such as showing a message to the user
                }
            });
        });

        // Function to check if new password matches with confirm password
        $("#confirmPassword").keyup(function() {
            var newPassword = $("#newPassword").val();
            var confirmPassword = $(this).val();
            if (newPassword !== confirmPassword) {
                $("#confirmPasswordError").text("Passwords do not match");
            } else {
                $("#confirmPasswordError").text("");
            }
        });

        // Form submission
        $("#changePasswordForm").submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Check if old password is correct and new password matches confirm password
            if ($('#oldPasswordError').text() === '' && $('#confirmPasswordError').text() === '') {
                var oldPassword = $("#oldPassword").val();
                var newPassword = $("#newPassword").val();

                $.ajax({
                    url: 'password.php',
                    type: 'post',
                    data: {
                        oldPassword: oldPassword,
                        newPassword: newPassword
                    },
                    success: function(response) {
                        if (response.trim() === "true") {
                            // Password changed successfully
                            $("#message").text("Password changed successfully!").show();
                            $("#oldPassword").val("");
                            $("#newPassword").val("");
                            $("#confirmPassword").val("");
                        } else {
                            // Error occurred while changing password
                            $("#message").text("Error occurred while changing password")
                                .show();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // This function will be executed if the request fails
                        console.log("Error:", textStatus, errorThrown);
                        // You can handle the error here, such as showing a message to the user
                    }
                });
            }
        });
    });
    </script>
</body>

</html>
<?php
// Close the database connection
$conn->close();
?>