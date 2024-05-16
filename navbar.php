<style>
.navbar {
    background-color: #f4f4f4;
    color: white;
    font-family: Arial, sans-serif;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}

.navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    /* Align items vertically */
}

.navbar ul li {
    margin-left: 10px;
    /* Adjust spacing between navbar items */
}

.navbar ul li a {
    color: black;
    font-size: 30px;
    cursor: pointer;
}

.navbar ul li a:hover {
    background-color: gray;
}

.navbar ul li i:hover {
    background-color: gray;
}

.navbar ul li i {
    color: black;
    font-size: 20px;
    cursor: pointer;
}
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fas fa-user"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
            </li>
        </ul>
    </nav>
</body>

</html>