<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    .navbar-custom {
        background: linear-gradient(135deg, #007bff, #6610f2);
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        padding: 6px 12px;
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-link {
        margin-left: 10px;
        padding: 8px 15px;
        border-radius: 8px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: Black !important;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/../../models/CategoryModel.php';
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->getAllCategories();
    ?>
    <div class="bg-light text-dark">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">My Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="d-flex" role="search" action="#" method="GET">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Search..."
                        aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        <?php if (!isset($_SESSION['user_email'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="/spri/day24/blog23/views/post/user.php">Home</a>
                        </li>
                        <?php endif; ?>


                        <?php if (!isset($_SESSION['user_email'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewAll">Post</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/spri/day24/blog23/index.php?action=viewAll">Post</a>
                        </li>
                        <?php endif; ?>


                        <?php if (isset($_SESSION['user_email'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Category
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li>
                                    <a class="dropdown-item <?= empty($_GET['category']) ? 'active' : '' ?>"
                                        href="?category=">
                                        All Categories
                                    </a>
                                </li>
                                <?php foreach ($categories as $category): ?>
                                <li>
                                    <a class="dropdown-item <?= (isset($_GET['category']) && $_GET['category'] == $category['category_id']) ? 'active' : '' ?>"
                                        href="?category=<?= $category['category_id']; ?>">
                                        <?= htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>


                        <li class="nav-item">
                            <a class="nav-link" href="#">Author</a>
                        </li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/admin/admin_dashboard.php">Admin Dashboard</a>
                        </li>
                        <?php endif; ?>



                        <?php if (isset($_SESSION['user_email'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-warning text-white px-3" href="#"
                                id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome: <?= htmlspecialchars($_SESSION['user_email']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item text-danger"
                                        href="/spri/day24/blog23/auth/logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/signup.php">Register</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>