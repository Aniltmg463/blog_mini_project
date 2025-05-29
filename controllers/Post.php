<?php
require_once 'models/post_model.php'; // make sure the path is correct

class Post
{
    private $conn;
    private $table = "posts";
    private $data;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->model = new post_model($db); // Pass DB to model
    }

    public function create()
    {
        // $stmt = $this->conn->prepare("INSERT INTO $this->table (title, body, date) VALUES (?, ?, ?)");
        // $stmt->bind_param("sss", $title, $body, $date);
        // if (!$stmt) {
        //     die("Prepare failed: " . $this->conn->error);
        // }
        // return $stmt->execute();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* $post->create($_POST['title'], $_POST['body']);
            header('Location: index.php'); */
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $this->model->create($title, $body, $date);
            header('Location: index.php');
        } else {
            include 'views/post/create.php';
        }
    }

    public function read()
    {
        /* $result = $this->conn->query("SELECT * FROM $this->table");
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts; */

        /*   echo "<pre>";
        print_r($model = $this->conn->read());
        die;
        echo "</pre>"; */


        return $this->model->read();
        include 'views/index.php';
    }

    public function readOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id, $title, $body, $date)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET title = ?, body = ?, date = ? WHERE post_id = ?");
        $stmt->bind_param("sssi", $title, $body, $date, $id);
        return $stmt->execute();
    }

    /*   public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    } */
    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->model->delete($id)) {
            header("Location: index.php");
            exit;
        }
    }
}
