<?php
require_once __DIR__ . '/../core/Model.php';

class post_model extends Model
{
    private $table = 'posts';

    public function read()
    {
        $query = "SELECT posts.*, users.name AS user_name 
                  FROM posts 
                  LEFT JOIN users ON posts.user_id = users.user_id";
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function create($title, $body, $date, $user_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO posts (title, body, date, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $body, $date, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE post_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function update($id, $title, $body, $date)
    {
        $stmt = $this->conn->prepare("UPDATE posts SET title = ?, body = ?, date = ? WHERE post_id = ?");
        $stmt->bind_param("sssi", $title, $body, $date, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT user_id, name FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // New methods for user management
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

    public function getUserById($user_id)
    {
        $query = "SELECT user_id, name, email, phone, role FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

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

    // For testing
    public function readtry()
    {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}