<?php
require_once __DIR__ . '/User.php';

class Admin extends User
{
    public function login($email, $password): bool
    {
        $stmt = $this->db->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }

        return false;
    }
}