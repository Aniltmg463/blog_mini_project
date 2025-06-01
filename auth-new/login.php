<?php
session_start();

require_once '../auth/Admin.php';
require_once '../auth/Author.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    $user = null;

    if ($role === 'admin') {
        $user = new Admin($username, $password);
    } elseif ($role === 'author') {
        $user = new Author($username, $password);
    }

    if ($user && $user->login($username, $password)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Invalid credentials";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <label>Role:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="author">Author</option>
        </select><br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>