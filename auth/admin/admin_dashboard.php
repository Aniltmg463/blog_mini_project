<?php
// session_start();

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     $_SESSION['msg'] = "Access denied. Admins only.";
//     header("Location: ../login.php");
//     exit;
// }

require_once '../../models/PostModel.php';
$post_model = new PostModel();
$users = $post_model->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="mb-4">Admin Dashboard - User Management</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="../logout.php" class="btn btn-danger">Logout</a>
            <a href="user_admin.php" class="btn btn-success">Add New User</a>
        </div>
        <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($_SESSION['msg']);
                unset($_SESSION['msg']); ?>
        </div>
        <?php endif; ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <a href="user_edit.php?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="user_delete.php?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>