<?php
require_once __DIR__ . '/../models/PostModel.php';

class Post
{
    private $model;

    public function __construct()
    {
        $this->model = new PostModel();
    }

    public function read()
    {
        return $this->model->read();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $body = strip_tags($_POST['body'] ?? '');
            $date = $_POST['date'];
            $category = $_POST['category'];

            if (isset($_SESSION['user_email']) && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            } else {
                $_SESSION['msg'] = 'You must be logged in to create a post.';
                header('Location: auth/login.php');
                exit;
            }

            $imageName = $_FILES['image']['name'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $uploadPath = 'uploads/' . basename($imageName);

            if (move_uploaded_file($imageTmp, $uploadPath)) {
                $result = $this->model->create($title, $body, $date, $category, $uploadPath, $user_id);
                if ($result) {
                    $_SESSION['msg'] = 'Post created successfully!';
                    header('Location: views/post/user.php');
                    exit;
                } else {
                    $_SESSION['msg'] = 'Failed to create post.';
                }
            } else {
                $_SESSION['msg'] = 'Image upload failed.';
            }

            header('Location: index.php?action=create');
        } else {
            include __DIR__ . '/../views/post/create.php';
        }
    }

    // public function read_user()
    // {
    //     return $this->model->read_user();
    // }

    public function view()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $postDetails = $this->model->readOne($id);
            include __DIR__ . '/../views/post/view.php';
        } else {
            $_SESSION['msg'] = 'Invalid post ID.';
            header('Location: views/post/user.php');
            exit;
        }
    }

    public function viewAll()
    {
        $posts = $this->model->read();
        include __DIR__ . '/../views/post/viewAll.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $body = $_POST['body'] ?? '';
            $date = $_POST['date'] ?? '';

            if ($this->model->update($id, $title, $body, $date)) {
                $_SESSION['msg'] = 'Post updated successfully!';
                header('Location: views/post/user.php');
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
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->model->delete($id)) {
                $_SESSION['msg'] = 'Post deleted successfully!';
            } else {
                $_SESSION['msg'] = 'Failed to delete post.';
            }
            header('Location: views/post/user.php');
            exit;
        }
    }

    public function getPostsByCategory($categoryId)
    {
        return $this->model->getPostsByCategory($categoryId);
    }
}

// Handle category filter logic
$postController = new Post();
$selectedCategoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;

$posts = $selectedCategoryId
    ? $postController->getPostsByCategory($selectedCategoryId)
    : $postController->read();