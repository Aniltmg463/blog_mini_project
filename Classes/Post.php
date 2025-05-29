<?php
class Post
{
    private $conn;
    private $table = "posts";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($title, $body)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (title, body) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $body);
        return $stmt->execute();
    }

    public function read()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }

    public function readOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id, $title, $body)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET title = ?, body = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $body, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}