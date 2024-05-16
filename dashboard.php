<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}

// Display welcome message with the username
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
    <style>
    /* Sidebar */
    .sidebar {
        float: left;
        width: 20%;
        /* Adjust this value according to your preference */
        background-color: #f2f2f2;
        padding: 20px;
    }

    /* Content */
    .content {
        float: right;
        width: 80%;
        /* Adjust this value according to your preference */
        padding: 20px;
    }

    /* Clearfix */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p>This is the dashboard page. You are now logged in.</p>
    </div>

    <div class="clearfix"></div>
</body>

</html>