<?php
require_once __DIR__ . '/../core/Model.php';

class CategoryModel extends Model
{
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $result = $this->conn->query($sql);

        $categories = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        // echo "<pre>";
        // print_r($categories);
        // echo "</pre>";
        // die;


        return $categories;
    }
}