<?php
require_once __DIR__ . '/../core/Model.php';

class PostModel extends Model
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

    // ✅ Post CRUD
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

    public function create($title, $body, $date, $category_id, $image, $user_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO posts (title, body, date, category_id, image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $title, $body, $date, $category_id, $image, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update($id, $title, $body, $date, $file)
    {
        $stmt = $this->conn->prepare("UPDATE posts SET title = ?, body = ?, date = ?, image = ? WHERE post_id = ?");
        $stmt->bind_param("ssssi", $title, $body, $date, $file, $id);
        return $stmt->execute();
    }


    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ✅ Categories
    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT category_id, name FROM categories");
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $categories;
    }



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

    public function getPostsByCategory($categoryId)
    {
        $stmt = $this->conn->prepare("SELECT posts.*, users.name AS user_name FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }

    public function getAllPosts()
    {
        $query = "SELECT posts.*, users.name AS user_name 
              FROM posts 
              LEFT JOIN users ON posts.user_id = users.user_id 
              ORDER BY posts.post_id DESC"; // Optional: latest first

        $result = $this->conn->query($query);
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        return $posts;
    }
}