<?php
session_start();

require_once 'controllers/Post.php';
require_once 'controllers/User.php';
require_once 'models/PostModel.php';
require_once 'models/UserModel.php';

$user = new User();
$post = new Post();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'login':
        $user->login();
        break;
    case 'signup':
        $user->signup();
    case 'user':
        $user->read_user();
        break;
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
    default:
        $posts = $post->read();
        include 'views/index.php';
        break;
}