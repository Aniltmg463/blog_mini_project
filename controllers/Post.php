<?php
require_once __DIR__ . '/../models/post_model.php';
$postController = new Post();

$selectedCategoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;

if ($selectedCategoryId) {
    $posts = $postController->getPostsByCategory($selectedCategoryId);
} else {
    $posts = $postController->read(); // Fallback to all posts
}

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            // $body = $_POST['body'];
            $body =  strip_tags($_POST['body'] ?? '');
            $date = $_POST['date'];
            $category = $_POST['category'];

            // echo "<pre>";
            // print_r($_POST);
            // print_r($_SESSION['user_email']);
            // echo "</pre>";
            // exit;

            // Check if user is logged in
            if (isset($_SESSION['user_email']) && isset($_SESSION['user_id'])) {
                // echo "<pre>";
                // print_r($_SESSION['user_id']);
                // print_r($_SESSION['user_email']);
                // echo "</pre>";
                // exit;


                $user_id = $_SESSION['user_id'];
            } else {
                $_SESSION['msg'] = 'You must be logged in to create a post.';
                header('Location: auth/login.php');
                exit;
            }

            // Handle image upload
            $imageName = $_FILES['image']['name'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $uploadPath = 'uploads/' . basename($imageName);

            if (move_uploaded_file($imageTmp, $uploadPath)) {
                // Call model to create post
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


    public function login()
    {
        // session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Please fill in all fields!";
                header("Location: auth/login.php");
                exit;
            }
            $user = $this->model->login($email, $password);

            // var_dump($user);
            // die;

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_id'] = $user['user_id'];

                // echo "<pre>";
                // print_r($user['user_id']);
                // echo "<br>";
                // print_r($user['email']);
                // echo "</pre>";
                // exit;


                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: auth/admin/admin_dashboard.php");
                } elseif ($user['role'] === 'student') {
                    header("Location: views/post/user.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $_SESSION['error'] = "Invalid credentials.";
                header("Location: login.php");
                exit;
            }
        }
        include __DIR__ . '/../auth/login.php';
    }

    public function signup()
    {
        // session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = trim($_POST['role'] ?? '');

            // Validate role
            if (!in_array($role, ['student', 'admin'])) {
                $_SESSION['error'] = "Invalid role selected.";
                header("Location: auth/signup.php");
                exit;
            }

            // Validate required fields
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['msg'] = "All fields are required.";
                header("Location: auth/signup.php");
                exit;
            }

            // Call model signup method
            $userExists = $this->model->checkUserExists($email);

            if ($userExists) {
                $_SESSION['error'] = "Email is already registered.";
                header("Location: auth/signup.php");
                exit;
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create user
            $created = $this->model->signup($name, $email, $hashedPassword, $role);

            if ($created) {
                $_SESSION['msg'] = "Signup successful. Please login.";
                header("Location: auth/login.php");
                exit;
            } else {
                $_SESSION['msg'] = "Signup failed. Please try again.";
                header("Location: auth/signup.php");
                exit;
            }
        }

        // Show the signup form if not POST
        include __DIR__ . '/../auth/signup.php';
    }

    public function read_user()
    {
        // session_start();
        return $this->model->read_user();
        // include __DIR__ . '/../views/post/user.php';
    }


    public function view()
    {
        // // session_start();
        // if (isset($_GET['id'])) {
        //     $id = $_GET['id'];
        //     $postDetails = $this->model->readOne($id);
        //     include __DIR__ . '/../views/post/view.php';
        // } else {
        //     $_SESSION['msg'] = 'Invalid post ID.';
        //     header('Location: index.php');
        //     exit;
        // }

        //  session_start(); // Make sure the session is started

        if (!isset($_SESSION['user_email'])) {
            // User is not logged in
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $postDetails = $this->model->readOne($id);
                include __DIR__ . '/../views/post/view.php';
            } else {
                $_SESSION['msg'] = 'Invalid post ID.';
                header('Location: index.php');
                exit;
            }
        } else {
            // User is logged in
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
    }

    public function update()
    {
        // session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $body = $_POST['body'] ?? '';
            $date = $_POST['date'] ?? '';

            if ($this->model->update($id, $title, $body, $date)) {
                $_SESSION['msg'] = 'Post updated successfully!';
                // header('Location: index.php');
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
        session_start();
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

    public function getUserByEmail($email)
    {
        return $this->model->getUserByEmail($email);
    }

    // public function getPostsByCategory($categoryId)
    // {
    //     // SQL query using a placeholder for prepared statement
    //     $sql = "SELECT posts.*, users.name AS user_name
    //         FROM posts 
    //         JOIN users ON posts.user_id = users.id 
    //         WHERE posts.category_id = ?";

    //     // Prepare the statement
    //     $stmt = $this->model->prepare($sql);

    //     // Check if preparation was successful
    //     if (!$stmt) {
    //         die("Prepare failed: " . $this->model->error);
    //     }

    //     // Bind the parameter (i = integer)
    //     $stmt->bind_param("i", $categoryId);

    //     // Execute the statement
    //     $stmt->execute();

    //     // Get the result set
    //     $result = $stmt->get_result();

    //     // Fetch all posts as an associative array
    //     $posts = [];
    //     if ($result && $result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $posts[] = $row;
    //         }
    //     }

    //     // Close the statement
    //     $stmt->close();

    //     return $posts;
    // }

    public function getPostsByCategory($categoryId)
    {
        return $this->model->getPostsByCategory($categoryId);
    }
}
