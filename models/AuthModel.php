<?php
require_once __DIR__ . '/../core/Model.php';

class AuthModel extends Model
{
    public function findUserByEmailAndPhone($email, $phone)
    {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND phone = ?");
        if (!$stmt) {
            return "Error: " . $conn->error;
        }

        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        $found = $stmt->num_rows > 0;
        $stmt->close();

        return $found;
    }

    public function updatePassword($email, $new_password)
    {
        $conn = $this->getConnection();
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if (!$stmt) {
            return "Error: " . $conn->error;
        }

        $stmt->bind_param("ss", $hashed_password, $email);
        $success = $stmt->execute();
        $stmt->close();

        return $success ? true : "Failed to update password: " . $conn->error;
    }
}
