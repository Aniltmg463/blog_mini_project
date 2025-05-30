<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: auth/login.php');
    exit();
}

require_once 'controllers/Post.php';
$post = new Post();


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
