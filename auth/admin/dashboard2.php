<?php
session_start();
require_once __DIR__ . '/../../controllers/Post.php';
// session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "You are not logged in.";
    exit;
}

// Access session values
$userEmail = $_SESSION['user_email'];
$userRole = $_SESSION['user_role'] ?? 'N/A';

// Use public method to get users
$postController = new Post();
$users = $postController->read_user();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Page</title>
    <style>
    table {
        border-collapse: collapse;
        width: 80%;
    }

    th,
    td {
        border: 1px solid #999;
        padding: 8px;
    }

    th {
        background-color: #eee;
    }
    </style>
</head>

<body>
    <h2>Welcome, Admin Dashboard!</h2>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($userRole); ?></p>

    <li><a class="dropdown-item text-danger" href="../../auth/logout.php">Logout</a></li>

    <hr>

    <h3>All Users</h3>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>phone</th>
                <th>Role</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>

                <td>
                    <a href="?action=view&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-primary"> view</a>
                    <a href="?action=edit&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-primary">✏️ Edit</a>
                    <a href="?action=delete&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>



                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>