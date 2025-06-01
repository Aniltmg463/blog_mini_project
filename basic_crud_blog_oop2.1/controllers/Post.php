<?php
require_once __DIR__ . '/../models/post_model.php';

class Post
{
    private $model;

    public function __construct()
    {
        $this->model = new post_model();
    }

    public function login_process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['msg'] = "Please fill in all fields!";
                header("Location: auth/login.php");
                exit;
            }

            $user = $this->model->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['msg'] = "Invalid credentials!";
                header("Location: auth/login.php");
                exit;
            }
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $body = strip_tags($_POST['body']);
            $date = $_POST['date'];
            $userid = $_POST['userid'];
            $this->model->create($title, $body, $date, $userid);
            header('Location: index.php');
        } else {
            include __DIR__ . '/../views/post/create.php';
        }
    }

    public function read()
    {
        return $this->model->read();
        include __DIR__ . '/../views/index.php';
    }

    // public function readOne()
    // {
    //     return $this->model->readOne($id);
    //     include __DIR__ . '/../views/post/view.php';
    // }

    public function readOne($id)
    {
        // $result = readOne($this->model, $_GET['id']);

        // if ($result && $result->num_rows > 0) {
        //     $student = $result->fetch_assoc();
        // } else {
        //     die("POst not found.");
        // }

        return $this->model->readOne($id);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $post = $this->model->readOne($id);
            include __DIR__ . '/../views/post/view.php';
        } else {
            echo "Post ID is missing.";
        }
    }

    public function update()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = $_POST['date'];
            $this->model->update($id, $title, $body, $date);
            header('Location: index.php');
        } else {
            $data = $this->model->readOne($id);
            include __DIR__ . '/../views/post/edit.php';
        }
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->model->delete($id)) {
            header("Location: index.php");
            exit;
        }
    }

    public function home()
    {
        // $id = isset($_GET['id']) ? $_GET['id'] : null;
        // if ($this->model->delete($id)) {
        //     header("Location: index.php");
        //     exit;
        // }

        // echo "Welcome to the post controller home page!";
        // echo "<br>";
        return $this->model->home();
    }
}