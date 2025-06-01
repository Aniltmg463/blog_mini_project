<?php
// require_once 'core/Model.php';
require_once __DIR__ . '/../core/Model.php'; // ✅ Correct


class post_model extends Model
{
    private $table = 'posts'; // match your table name

    public function read()
    {
        $query = "SELECT posts.*, users.name AS user_name 
              FROM posts 
              LEFT JOIN users ON posts.user_id = users.user_id";

        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }


    public function create($title, $body, $date, $userid)
    {
        $stmt = $this->conn->prepare("INSERT INTO posts (title, body, date, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $body, $date, $userid);
        $result =  $stmt->execute();
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
        $stmt->bind_param("sssi", $title, $body, $date,  $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $id = (int)$this->conn->real_escape_string($id);
        $query = "DELETE FROM " . $this->table . " WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);
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



    //this is only for testing purposes
    public function readtry()
    {
        $query = "SELECT * from users";

        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
