<?php
session_start();

require_once 'controllers/PostController.php';
require_once 'controllers/UserController.php';
// require_once 'controllers/AuthController.php';
require_once 'models/PostModel.php';
require_once 'models/UserModel.php';
// require_once 'models/AuthModel.php';

$user = new UserController();
$post = new PostController();
// $auth = new AuthController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'login':
        $user->login();
        break;

    case 'signup':
        $user->signup();
        break;

    // case 'reset-password':
    //     $auth->resetPassword();
    //     break;

    case 'user':
        $user->read_user();
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
