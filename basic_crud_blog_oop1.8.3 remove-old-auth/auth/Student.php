<?php

require_once __DIR__ . '/User.php';

class Student extends User
{
    public function login($email, $password): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        if ($student) {
            $_SESSION['email'] = $student['email'];
            $_SESSION['role'] = 'student';
            return true;
        }

        return false;
    }
}