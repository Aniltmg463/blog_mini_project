<?php
session_start();

require __DIR__ . '/../config/Database.php';

// require_once '../functions/Student.php';

$db = new Database();
$db = $db->connect();

/* if ($db->connect()) {
    echo "<div class='alert alert-success'>Database connected successfully.</div>";
} else {
    echo "<div class='alert alert-danger'>Database connection failed.</div>";
    exit();
}
 */

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['msg'] = "Please fill in all fields!";
        header("Location: login.php");
        exit;
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        if ($student) {
            $_SESSION['email'] = $email;

            // echo "<pre>";
            // print_r($_SESSION['email']);
            // echo "</pre>";
            // die;

            // $_SESSION['user_id'] = $student['id'];
            // $_SESSION['msg'] = $student['login success'];

            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['msg'] = 'Login failed!';
            header("Location: login.php");
            exit;
        }
    }
}