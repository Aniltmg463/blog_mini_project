<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function resetPassword($email, $phone, $new_password)
    {
        $conn = $this->model->getConnection(); // Get protected connection via method

        // Step 1: Check if user exists with the given email and phone
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND phone = ?");
        if (!$stmt) {
            return "Database error: " . $conn->error;
        }

        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();

            // Step 2: Hash the new password before updating
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            if (!$update) {
                return "Failed to prepare update query: " . $conn->error;
            }

            $update->bind_param("ss", $hashed_password, $email);
            if ($update->execute()) {
                $update->close();
                return "Password reset successfully.";
            } else {
                $update->close();
                return "Failed to reset password.";
            }
        } else {
            $stmt->close();
            return "Incorrect email or phone.";
        }
    }
}
