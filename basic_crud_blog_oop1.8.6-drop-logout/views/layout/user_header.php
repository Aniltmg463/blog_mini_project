<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    header.header {
        background: #f8f9fa;
        padding: 10px 0;
        border-bottom: 1px solid #ccc;
    }

    .header .logo {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        text-decoration: none;
    }

    .search-form input[type="text"] {
        max-width: 200px;
    }

    .navbar a {
        margin-right: 10px;
        text-transform: capitalize;
    }

    .profile .name {
        font-weight: bold;
    }

    .profile .btn,
    .profile .delete-btn {
        margin-top: 5px;
    }

    .icons i {
        cursor: pointer;
        margin-right: 10px;
    }
    </style>
</head>

<body>



    <header class="header">
        <div class="container d-flex flex-wrap align-items-center justify-content-between">

            <a href="home.php" class="logo">Blogo.</a>

            <form class="d-flex search-form" action="search.php" method="POST">
                <input type="text" name="search_box" class="form-control me-2" placeholder="Search for blogs" required>
                <button type="submit" name="search_btn" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="icons d-flex align-items-center">
                <i id="menu-btn" class="fas fa-bars"></i>
                <i id="search-btn" class="fas fa-search"></i>
                <i id="user-btn" class="fas fa-user"></i>
            </div>

        </div>

        <div class="container mt-2 d-flex flex-wrap justify-content-between align-items-center">
            <nav class="navbar">
                <a href="home.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Home</a>
                <a href="posts.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Posts</a>
                <a href="all_category.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Category</a>
                <a href="authors.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Authors</a>
                <a href="login.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Login</a>
                <a href="register.php" class="nav-link d-inline"><i class="fas fa-angle-right"></i> Register</a>
            </nav>

            <div class="profile text-end">
                <p class="name mb-1">User Name Here</p>
                <!-- <a href="update.php" class="btn btn-sm btn-primary">Update Profile</a> -->
                <!-- <div class="d-flex gap-2 mt-2">
                    <a href="login.php" class="btn btn-sm btn-outline-success">Login</a>
                    <a href="register.php" class="btn btn-sm btn-outline-primary">Register</a>
                </div> -->
                <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');"
                    class="btn btn-sm btn-danger mt-2">Logout</a>
            </div>
        </div>
    </header>
    <!-- Optional message alert example -->
    <div class="container mt-3">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Sample message goes here.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>