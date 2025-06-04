<?php
session_start();

require_once 'controllers/Post.php';
require_once 'models/PostModel.php';

$post = new Post();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'login':
        $post->login();
        break;
    case 'signup':
        $post->signup();
        break;
    case 'view':
        $post->view();
        break;
    case 'viewAll':
        $post->viewAll();
        break;
    case 'create':
        $post->create();
        break;
    case 'edit':
        $post->update();
        break;
    case 'delete':
        $post->delete();
        break;
    case 'user':
        $post->read_user();
        break;

    default:
        $posts = $post->read();
        include 'views/index.php';
        break;
}