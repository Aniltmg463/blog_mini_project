<?php
require_once __DIR__ . '/../core/Model.php';

class User_model extends Model
{
    private $table = 'posts';

    public function checkUserExists($email)
    {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function signup($name, $email, $hashedPassword, $role)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}