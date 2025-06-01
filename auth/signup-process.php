<?php
session_start();

require_once '../models/post_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get submitted data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['msg'] = "All fields are required.";
        header("Location: signup.php");
        exit;
    }

    // Connect to DB
    $db = new post_model();
    $conn = $db->getConnection();

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['msg'] = "Email is already registered.";
        header("Location: signup.php");
        exit;
    }

    // Insert user (you can also hash the password here)
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Signup successful. Please login.";
        header("Location: auth/login.php");
        exit;
    } else {
        $_SESSION['msg'] = "Signup failed. Please try again.";
        header("Location: auth/signup.php");
        exit;
    }
}
