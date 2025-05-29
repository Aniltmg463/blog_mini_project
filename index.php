<?php
require_once 'config/Database.php';
require_once 'controllers/Post.php';
require_once 'models/post_model.php';

// $db = (new Database())->connect();
$db = new Database();
$db = $db->connect();
$post = new Post($db);

// $action = $_GET['action'] ?? 'index';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* $post->create($_POST['title'], $_POST['body']);
            header('Location: index.php'); */
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $post->create($title, $body, $date);
            header('Location: index.php');
        } else {
            include 'views/post/create.php';
        }
        break;

    case 'edit':
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $post->update($id, $_POST['title'], $_POST['body']);
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $post->update($id, $title, $body, $date);
            header('Location: index.php');
        } else {
            $data = $post->readOne($id);
            include 'views/post/edit.php';
        }
        break;

    case 'delete':
        $post->delete($_GET['id']);
        header('Location: index.php');
        break;

    default:
        $posts = $post->read();
        include 'views/index.php';
        break;
}
