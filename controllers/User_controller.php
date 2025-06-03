<?php
session_start();
require_once __DIR__ . '/../models/User_model.php';

class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = new User_model();
    }

    public function add_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role     = trim($_POST['role'] ?? '');

            // Validate role
            if (!in_array($role, ['student', 'admin'])) {
                $_SESSION['error'] = "Invalid role selected.";
                header("Location: ../auth/signup.php");
                exit;
            }

            // Validate required fields
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['msg'] = "All fields are required.";
                header("Location: auth/admin/add_user.php");
                exit;
            }

            // Check if email already exists
            if ($this->model->checkUserExists($email)) {
                $_SESSION['error'] = "Email is already registered.";
                header("Location: auth/admin/add_user.php");
                exit;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create user
            $created = $this->model->signup($name, $email, $hashedPassword, $role);

            if ($created) {
                $_SESSION['msg'] = "New User added successful. Please login.";
                header("Location: ../auth/login.php");
                exit;
            } else {
                $_SESSION['msg'] = "User added failed. Please try again.";
                header("Location: ../auth/signup.php");
                exit;
            }
        } else {
            // Show the signup form
            include __DIR__ . '/../auth/signup.php';
        }
    }
}

// Usage
$controller = new UserController();
$controller->add_user();