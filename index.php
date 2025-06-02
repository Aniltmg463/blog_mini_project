<?php
session_start();

//old auth
// if (!isset($_SESSION['email'])) {
//     header('Location: auth/login.php');
//     exit();
// }

//new auth
// session_start();
// if (!isset($_SESSION['user'])) {
//     header('Location: auth/login.php');
//     exit();
// }

require_once 'controllers/Post.php';
require_once 'models/post_model.php';

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