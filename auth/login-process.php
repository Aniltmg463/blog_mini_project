<?php
session_start();
require_once '../models/post_model.php';
require_once 'Student.php';
require_once 'Admin.php';

$post_model = new post_model();
$db = $post_model->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields!";
        header("Location: login.php");
        exit;
    }

    // Check if user exists
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // if ($user && password_verify($password, $user['password'])) {
    //     // Set session values
    //     $_SESSION['user_id'] = $user['user_id'];
    //     $_SESSION['username'] = $user['name'];
    //     $_SESSION['email'] = $user['email'];
    //     $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'admin') {
        header("Location: admin/admin_dashboard.php");
    } elseif ($user['role'] === 'student') {
        header("Location: ../index.php");
    } else {
        header("Location: ../Views/index.php");
    }
    exit;
} else {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: login.php");
    exit;
}
