<?php
require_once __DIR__ . '/../models/PostModel.php';

class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel(); // You may rename this to UserModel if you separate models later
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // $_session['postEmail'] = $email;
            // echo  $_session['postEmail'];
            // die;

            // Sanitize email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Please fill in all fields!";
                header("Location: auth/login.php");
                exit;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format.";
                header("Location: auth/login.php");
                exit;
            }

            $user = $this->model->login($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_id'] = $user['user_id'];


                // echo "<pre>";
                // print_r($user);
                // die;
                // echo "</pre>";

                if ($user['role'] === 'admin') {
                    header("Location: auth/admin/admin_dashboard.php");
                } elseif ($user['role'] === 'user') {
                    header("Location: views/post/user.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $_SESSION['error'] = "Invalid credentials.";
                header("Location: auth/login.php");
                exit;
            }
        }

        include __DIR__ . '/../auth/login.php';
    }


    // public function login()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = $_POST['email'] ?? '';
    //         $password = $_POST['password'] ?? '';

    //         if (empty($email) || empty($password)) {
    //             $_SESSION['error'] = "Please fill in all fields!";
    //             header("Location: auth/login.php");
    //             exit;
    //         }

    //         $user = $this->model->login($email, $password);

    //         if ($user) {
    //             $_SESSION['user'] = $user;
    //             $_SESSION['user_email'] = $user['email'];
    //             $_SESSION['user_role'] = $user['role'];
    //             $_SESSION['user_id'] = $user['user_id'];

    //             if ($user['role'] === 'admin') {
    //                 header("Location: auth/admin/admin_dashboard.php");
    //             } elseif ($user['role'] === 'student') {
    //                 header("Location: views/post/user.php");
    //             } else {
    //                 header("Location: index.php");
    //             }
    //             exit;
    //         } else {
    //             $_SESSION['error'] = "Invalid credentials.";
    //             header("Location: login.php");
    //             exit;
    //         }
    //     }

    //     include __DIR__ . '/../auth/login.php';
    // }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = trim($_POST['role'] ?? '');

            // Sanitize inputs
            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $role = htmlspecialchars($role, ENT_QUOTES, 'UTF-8');

            // Validate role
            if (!in_array($role, ['user', 'admin'])) {
                $_SESSION['error'] = "Invalid role selected.";
                header("Location: auth/signup.php");
                exit;
            }

            // Validate required fields
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['msg'] = "All fields are required.";
                header("Location: auth/signup.php");
                exit;
            }

            // Validate email format
            /*   example: john.doe@example.com
anil123@gmail.com
student.name@university.edu
admin_01@company.co
my-email@domain.info */
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format.";
                header("Location: auth/signup.php");
                exit;
            }

            // Password strength suggestion (optional)
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters.";
                header("Location: auth/signup.php");
                exit;
            }

            $userExists = $this->model->checkUserExists($email);
            if ($userExists) {
                $_SESSION['error'] = "Email is already registered.";
                header("Location: auth/signup.php");
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $created = $this->model->signup($name, $email, $phone, $hashedPassword, $role);

            if ($created) {
                $_SESSION['msg'] = "Signup successful. Please login.";
                header("Location: auth/login.php");
                exit;
            } else {
                $_SESSION['msg'] = "Signup failed. Please try again.";
                header("Location: auth/signup.php");
                exit;
            }
        }

        include __DIR__ . '/../auth/signup.php';
    }


    // public function signup()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = trim($_POST['name'] ?? '');
    //         $email = trim($_POST['email'] ?? '');
    //         $password = trim($_POST['password'] ?? '');
    //         $role = trim($_POST['role'] ?? '');

    //         if (!in_array($role, ['student', 'admin'])) {
    //             $_SESSION['error'] = "Invalid role selected.";
    //             header("Location: auth/signup.php");
    //             exit;
    //         }

    //         if (empty($name) || empty($email) || empty($password)) {
    //             $_SESSION['msg'] = "All fields are required.";
    //             header("Location: auth/signup.php");
    //             exit;
    //         }

    //         $userExists = $this->model->checkUserExists($email);
    //         if ($userExists) {
    //             $_SESSION['error'] = "Email is already registered.";
    //             header("Location: auth/signup.php");
    //             exit;
    //         }

    //         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //         $created = $this->model->signup($name, $email, $hashedPassword, $role);

    //         if ($created) {
    //             $_SESSION['msg'] = "Signup successful. Please login.";
    //             header("Location: auth/login.php");
    //             exit;
    //         } else {
    //             $_SESSION['msg'] = "Signup failed. Please try again.";
    //             header("Location: auth/signup.php");
    //             exit;
    //         }
    //     }

    //     include __DIR__ . '/../auth/signup.php';
    // }

    public function getUserByEmail($email)
    {
        return $this->model->getUserByEmail($email);
    }
    public function read_user()
    {
        return $this->model->read_user();
    }
}