<?php
require_once '../controllers/AuthController.php';
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resetobj = new AuthController();
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $new_password = $_POST['new_password'];

    $message = $resetobj->resetPassword($email, $phone, $new_password);
    if ($message === "Password reset successfully.") {
        $success = $message;
    } else {
        $error = $message;
    }
}
?>

<!-- Same HTML as before -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Reset Password</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success text-center"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" required class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>

            <p class="text-center text-muted mt-3">
                Go back to <a href="login.php" class="text-decoration-none">Login</a>
            </p>
        </div>
    </div>
</body>

</html>