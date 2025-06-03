<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['msg'] = "Access denied. Admins only.";
    header("Location: ../login.php");
    exit;
}

require_once '../../models/post_model.php';
$post_model = new post_model();

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "User ID not provided.";
    header("Location: admin_dashboard.php");
    exit;
}

$user = $post_model->getUserById($_GET['id']);
if (!$user) {
    $_SESSION['msg'] = "User not found.";
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? 'student';
    $password = trim($_POST['password'] ?? '');

    if (empty($name) || empty($email)) {
        $_SESSION['msg'] = "Name and email are required.";
    } else {
        $result = $post_model->updateUser($user['user_id'], $name, $email, $phone, $role, $password ?: null);
        if ($result) {
            $_SESSION['msg'] = "User updated successfully.";
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $_SESSION['msg'] = "Failed to update user. Email may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="mb-4">Edit User</h2>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_SESSION['msg']);
                unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="w-50">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (Optional)</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone (Optional)</label>
                <input type="text" name="phone" id="phone" class="form-control"
                    value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>