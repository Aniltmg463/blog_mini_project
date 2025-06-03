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

require_once 'controllers/User_controller.php';
require_once 'models/User_model.php';

$post = new Post();
$user = new UserController();
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
    case 'user':
        $post->read_user();
        break;
    case 'add_user':
        $user->add_user();
        // includ

    default:
        $posts = $post->read();
        include 'views/index.php';
        break;
}