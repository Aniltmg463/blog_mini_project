<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "You are not logged in.";
    exit;
}

// Access session values
$userEmail = $_SESSION['user_email'];
$userRole = $_SESSION['user_role'] ?? 'N/A';
?>

<li><a class="dropdown-item text-danger" href="../../auth/logout.php">Logout</a></li>

<!DOCTYPE html>
<html>

<head>
    <title>User Page</title>
</head>

<body>
    <h2>Welcome, User!</h2>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($userRole); ?></p>
</body>

</html>