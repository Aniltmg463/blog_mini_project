<?php
require_once __DIR__ . '/../core/Model.php';

class CategoryController
{
    private $conn;

    public function __construct()
    {
        $model = new Model();
        $this->conn = $model->getConnection();
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