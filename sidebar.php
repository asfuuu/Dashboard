<!-- sidebar.php -->
<style>
.sidebar {
    background-color: #f4f4f4;
    width: 200px;
    padding: 20px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
}

.content {
    margin-left: 220px;
    /* Adjust as needed */
    padding: 20px;
    margin-top: 2rem;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    margin-top: 50px;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

.sidebar a:hover {
    color: red;
}

.sidebar a.active {
    color: red;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="sidebar">
    <a class="navbar-brand" href="#">PHP</a>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == "dashboard.php") echo "active"; ?>"
                href="dashboard.php" target="content">Dashboard</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == "brand.php") echo "active"; ?>"
                href="brand.php" target="content">Brand</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == "product.php") echo "active"; ?>"
                href="product.php" target="content">Product</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == "logout.php") echo "active"; ?>"
                href="logout.php" target="content">Logout</a>
        </li>
    </ul>
</div>


</div>