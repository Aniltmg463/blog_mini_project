<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['msg'] = "Access denied. Admins only.";
    header("Location: ../login.php");
    exit;
}

require_once '../../models/UserModel.php';
$user_model = new UserModel();

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "User ID not provided.";
    header("Location: admin_dashboard.php");
    exit;
}

if ($user_model->deleteUser($_GET['id'])) {
    $_SESSION['msg'] = "User deleted successfully.";
} else {
    $_SESSION['msg'] = "Failed to delete user.";
}

header("Location: admin_dashboard.php");
exit;