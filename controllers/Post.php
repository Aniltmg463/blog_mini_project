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
            // Sanitize input
            $title = trim(strip_tags($_POST['title'] ?? ''));
            $body = trim(strip_tags($_POST['body'] ?? ''));
            $date = trim($_POST['date'] ?? '');
            $category = trim(strip_tags($_POST['category'] ?? ''));

            // Validate required fields
            if (empty($title) || empty($body) || empty($date) || empty($category)) {
                $_SESSION['msg'] = 'All fields are required.';
                header('Location: index.php?action=create');
                exit;
            }

            // Validate date format (YYYY-MM-DD)
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
                $_SESSION['msg'] = 'Invalid date format.';
                header('Location: index.php?action=create');
                exit;
            }

            // Check if user is logged in
            if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_id'])) {
                $_SESSION['msg'] = 'You must be logged in to create a post.';
                header('Location: auth/login.php');
                exit;
            }

            $user_id = $_SESSION['user_id'];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageName = basename($_FILES['image']['name']);
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageSize = $_FILES['image']['size'];
                $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

                // Validate image extension
                if (!in_array($imageExt, $allowedExts)) {
                    $_SESSION['msg'] = 'Invalid image format. Allowed: jpg, jpeg, png, gif.';
                    header('Location: index.php?action=create');
                    exit;
                }

                // Validate image size (2MB max)
                if ($imageSize > 2 * 1024 * 1024) {
                    $_SESSION['msg'] = 'Image file is too large. Max size is 2MB.';
                    header('Location: index.php?action=create');
                    exit;
                }

                $uniqueImageName = uniqid('post_', true) . '.' . $imageExt;
                $uploadPath = 'uploads/' . $uniqueImageName;

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
            } else {
                $_SESSION['msg'] = 'Please upload a valid image.';
            }

            header('Location: index.php?action=create');
        } else {
            include __DIR__ . '/../views/post/create.php';
        }
    }


    // public function create()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $title = $_POST['title'];
    //         $body = strip_tags($_POST['body'] ?? '');
    //         $date = $_POST['date'];
    //         $category = $_POST['category'];

    //         if (isset($_SESSION['user_email']) && isset($_SESSION['user_id'])) {
    //             $user_id = $_SESSION['user_id'];
    //         } else {
    //             $_SESSION['msg'] = 'You must be logged in to create a post.';
    //             header('Location: auth/login.php');
    //             exit;
    //         }

    //         $imageName = $_FILES['image']['name'];
    //         $imageTmp = $_FILES['image']['tmp_name'];
    //         $uploadPath = 'uploads/' . basename($imageName);

    //         if (move_uploaded_file($imageTmp, $uploadPath)) {
    //             $result = $this->model->create($title, $body, $date, $category, $uploadPath, $user_id);
    //             if ($result) {
    //                 $_SESSION['msg'] = 'Post created successfully!';
    //                 header('Location: views/post/user.php');
    //                 exit;
    //             } else {
    //                 $_SESSION['msg'] = 'Failed to create post.';
    //             }
    //         } else {
    //             $_SESSION['msg'] = 'Image upload failed.';
    //         }

    //         header('Location: index.php?action=create');
    //     } else {
    //         include __DIR__ . '/../views/post/create.php';
    //     }
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
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

            // Validate and sanitize title
            $title = trim($_POST['title'] ?? '');
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            if (empty($title)) {
                $_SESSION['msg'] = 'Title is required.';
                header("Location: index.php?action=edit&id=$id");
                exit;
            }

            // Sanitize body (allow HTML from Summernote but remove scripts)
            $body = $_POST['body'] ?? '';
            $body = strip_tags($body, '<p><a><b><i><u><strong><em><br><ul><ol><li><span><div><img>'); // allow safe tags

            // Validate date
            $date = $_POST['date'] ?? '';
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $_SESSION['msg'] = 'Invalid date format.';
                header("Location: index.php?action=edit&id=$id");
                exit;
            }

            // Get existing post to retain old image
            $existingPost = $this->model->readOne($id);
            $existingImage = $existingPost['file'] ?? '';
            $uploadPath = $existingImage;

            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] !== 4) { // file was submitted
                $fileTmp = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
                $maxSize = 2 * 1024 * 1024; // 2 MB

                if (!in_array($fileExt, $allowedExt)) {
                    $_SESSION['msg'] = 'Only JPG, PNG, and GIF files are allowed.';
                    header("Location: index.php?action=edit&id=$id");
                    exit;
                }

                if ($fileSize > $maxSize) {
                    $_SESSION['msg'] = 'Image size should not exceed 2MB.';
                    header("Location: index.php?action=edit&id=$id");
                    exit;
                }

                if ($fileError === 0) {
                    $newFileName = time() . '_' . basename($fileName);
                    $destination = 'uploads/' . $newFileName;

                    if (move_uploaded_file($fileTmp, $destination)) {
                        if (!empty($existingImage) && file_exists($existingImage)) {
                            unlink($existingImage);
                        }
                        $uploadPath = $destination;
                    } else {
                        $_SESSION['msg'] = 'Failed to upload image.';
                        header("Location: index.php?action=edit&id=$id");
                        exit;
                    }
                } else {
                    $_SESSION['msg'] = 'File upload error.';
                    header("Location: index.php?action=edit&id=$id");
                    exit;
                }
            }

            // Call model to update
            if ($this->model->update($id, $title, $body, $date, $uploadPath)) {
                $_SESSION['msg'] = 'Post updated successfully!';
                header('Location: views/post/user.php');
                exit;
            } else {
                $_SESSION['msg'] = 'Failed to update post.';
                header("Location: index.php?action=edit&id=$id");
                exit;
            }
        }

        // Load edit view
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
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