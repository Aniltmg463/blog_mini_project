<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f4f4f4;
    }

    .form-container {
        max-width: 450px;
        margin: 80px auto;
    }

    .card {
        border-radius: 10px;
    }
    </style>
</head>

<body>

    <div class="container form-container">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Sign Up</h3>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="../index.php?action=signup">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Select Role</label>
                        <select name="role" class="form-select" required>
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    Already have an account? <a href="../index.php?action=login" class="text-decoration-none">Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>