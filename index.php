<?php
require_once 'config/Database.php';
require_once 'classes/Post.php';

$db = (new Database())->connect();
$post = new Post($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post->create($_POST['title'], $_POST['body']);
            header('Location: index.php');
        } else {
            include 'views/create.php';
        }
        break;

    case 'edit':
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post->update($id, $_POST['title'], $_POST['body']);
            header('Location: index.php');
        } else {
            $data = $post->readOne($id);
            include 'views/edit.php';
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
