<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .card {
            border-radius: 10px;
        }

        .form-container {
            max-width: 400px;
            margin: 80px auto;
        }
    </style>
</head>

<body>

    <div class="container form-container">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger text-center">
                        <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="../index.php?action=login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                            required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <p class="text-center text-gray-600 mt-2">
                    <a href="reset-password.php" class="text-blue-500 hover:underline">Forgot password?</a>

                    <!-- <a href="forget.php" class="text-blue-500 hover:underline">Forgot password?</a> -->
                </p>



                <div class="text-center mt-3">
                    Don't have an account? <a href="../index.php?action=signup" class="text-decoration-none">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>