<?php
session_start();

// require_once '../core/Model.php';
require_once '../models/post_model.php';
require_once 'Student.php';

$post_model = new post_model();
$db = $post_model->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['msg'] = "Please fill in all fields!";
        header("Location: login.php");
        exit;
    }

    $student = new Student($email, $password, $db);

    if ($student->login($email, $password)) {
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['msg'] = "Invalid credentials!";
        header("Location: login.php");
        exit;
    }
}