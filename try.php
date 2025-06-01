<?php
// session_start();
require_once 'config/Database.php';
require_once 'models/post_model.php';

$db = new Database();
$conn = $db->connect();
$postModel = new post_model($conn);

$users = $postModel->readtry();

// $email = $_SESSION['email']; // make sure session is set

// $query = "SELECT user_id, name FROM users WHERE email = ?";
// $stmt = $conn->prepare($query);
// $stmt->bind_param("s", $email);
// $stmt->execute();
// $result = $stmt->get_result();
// $user = $result->fetch_assoc();

// echo "Welcome, " . $user['name'] . " (User ID: " . $user['user_id'] . ")";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
</head>

<body>
    <h1>All user details</h1>
    <?php if (!empty($users) && is_array($users)): ?>
    <?php foreach ($users as $p): ?>
    <h2><?= htmlspecialchars($p['name']) ?></h2>
    <p><?= htmlspecialchars($p['email']) ?></p>
    <small>Password: <?= htmlspecialchars($p['phone']) ?></small><br>


    <a href="">Edit</a> |
    <a href="" onclick="return confirm('Delete?')">Delete</a>
    <hr>
    <?php endforeach; ?>
    <?php else: ?>
    <p>No posts found.</p>
    <?php endif; ?>

</body>

</html>