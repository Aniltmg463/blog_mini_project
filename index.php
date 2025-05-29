<?php
require_once 'config/Database.php';
require_once 'controllers/Post.php';
require_once 'models/post_model.php';

$db = new Database();
$db = $db->connect();
$post = new Post($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create':

        $post =  $post->create();
        break;

    case 'edit':
        $post->update();
        break;

    case 'delete':
        $post->delete();
        break;

    default:
        $posts = $post->read();
        include 'views/index.php';
        break;
}