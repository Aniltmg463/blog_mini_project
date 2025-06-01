<?php
require_once 'models/post_model.php';

class Post
{
    private $conn;
    private $table = "posts";
    private $model;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->model = new post_model($db);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $userid = $_POST['userid'];
            $this->model->create($title, $body, $date, $userid);
            header('Location: index.php');
        } else {
            include 'views/post/create.php';
        }
    }

    public function read()
    {
        return $this->model->read();
        include 'views/index.php';
    }

    public function update()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $this->model->update($id, $title, $body, $date);
            header('Location: index.php');
        } else {
            $data = $this->model->readOne($id);
            include 'views/post/edit.php';
        }
    }
    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->model->delete($id)) {
            header("Location: index.php");
            exit;
        }
    }
}
