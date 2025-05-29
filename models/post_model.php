<?php
class post_model
{
    private $conn;
    private $table = 'posts'; // match your table name

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM $this->table";
        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function create($title, $body, $date)
    {
        $stmt = $this->conn->prepare("INSERT INTO posts (title, body, date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $body, $date);
        $result =  $stmt->execute();
        return $result;
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
}
