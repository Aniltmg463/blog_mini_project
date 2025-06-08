<?php
require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model
{
    public function createUser($name, $email, $password, $phone, $role)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $role);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateUser($user_id, $name, $email, $phone, $role, $password = null)
    {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, role = ?, password = ? WHERE user_id = ?");
            $stmt->bind_param("sssssi", $name, $email, $phone, $role, $hashed_password, $user_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, role = ? WHERE user_id = ?");
            $stmt->bind_param("ssssi", $name, $email, $phone, $role, $user_id);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteUser($user_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function read_user()
    {
        $query = "SELECT * FROM users ORDER BY user_id ASC";
        $result = $this->conn->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }



    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

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

    public function signup($name, $email, $phone, $hashedPassword, $role)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, phone,password, role) VALUES (?, ?, ?, ?,?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $role);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT user_id, name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function getUserById($user_id)
    {
        $stmt = $this->conn->prepare("SELECT user_id, name, email, phone, role FROM users WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function getAllUsers()
    {
        $query = "SELECT user_id, name, email, phone, role FROM users ORDER BY user_id ASC";
        $result = $this->conn->query($query);
        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // public function readtry()
    // {
    //     $query = "SELECT * FROM users";
    //     $result = $this->conn->query($query);
    //     $data = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $data[] = $row;
    //     }
    //     return $data;
    // }
}
