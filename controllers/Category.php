<?php
require_once __DIR__ . '/../core/Model.php';

class Category extends Model
{
    public function __construct()
    {
        parent::__construct(); // calls the Model constructor to initialize $conn
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->conn->query($sql);

        $categories = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        return $categories;
    }
}
