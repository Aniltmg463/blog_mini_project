<?php
session_start();

//auth session
// if (!isset($_SESSION['email'])) {
//     header('Location: auth/login.php');
//     exit();
// }


require_once 'controllers/Post.php';
$post = new Post();

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'login':
        // $posts = $post->login_process();
        include 'auth/login.php';
        break;

    case 'create':
        $post =  $post->create();
        break;

    case 'edit':
        $post->update();
        break;

    case 'delete':
        $post->delete();
        break;

    case 'index':
        $posts = $post->read();
        include 'views/index.php';
        break;

    default:
        // $posts = $post->home();
        include 'views/home.php';
        break;
}