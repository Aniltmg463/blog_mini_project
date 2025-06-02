<?php
require_once __DIR__ . '/../models/post_model.php';

class Post
{
    private $model;

    public function __construct()
    {
        $this->model = new post_model();
    }

    public function read()
    {
        return $this->model->read();
    }

    public function create()
    {
        // session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $body = $_POST['body'] ?? '';
            $date = $_POST['date'] ?? '';
            $user_id = $_POST['userid'] ?? 0;

            if ($this->model->create($title, $body, $date, $user_id)) {
                $_SESSION['msg'] = 'Post created successfully!';
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['msg'] = 'Failed to create post.';
            }
        }
        include __DIR__ . '/../views/post/create.php';
    }

    public function view()
    {
        // session_start();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $postDetails = $this->model->readOne($id);
            include __DIR__ . '/../views/post/view.php';
        } else {
            $_SESSION['msg'] = 'Invalid post ID.';
            header('Location: index.php');
            exit;
        }
    }

    public function update()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $body = $_POST['body'] ?? '';
            $date = $_POST['date'] ?? '';

            if ($this->model->update($id, $title, $body, $date)) {
                $_SESSION['msg'] = 'Post updated successfully!';
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['msg'] = 'Failed to update post.';
            }
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $this->model->readOne($id);
            include __DIR__ . '/../views/post/edit.php';
        } else {
            $_SESSION['msg'] = 'Invalid post ID.';
            header('Location: index.php');
            exit;
        }
    }

    public function delete()
    {
        session_start();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->model->delete($id)) {
                $_SESSION['msg'] = 'Post deleted successfully!';
            } else {
                $_SESSION['msg'] = 'Failed to delete post.';
            }
            header('Location: index.php');
            exit;
        }
    }

    public function getUserByEmail($email)
    {
        return $this->model->getUserByEmail($email);
    }
}
