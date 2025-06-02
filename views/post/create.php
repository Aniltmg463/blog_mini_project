<?php
require_once 'models/post_model.php';

$db = new post_model();
$email = $_SESSION['email'] ?? '';
$user = $db->getUserByEmail($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Blog Post</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="mb-4 text-center">Create New Blog Post</h2>

        <form method="post" action="?action=create">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title" required>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Content:</label>
                <textarea id="body" name="body" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>

            <input type="hidden" name="userid" value="<?= htmlspecialchars($user['user_id']) ?>">

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Publish Post</button>
            </div>
        </form>
    </div>

    <!-- jQuery (Required by Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    <!-- Initialize Summernote -->
    <script>
    $(document).ready(function() {
        $('#body').summernote({
            height: 250
        });
    });
    </script>
</body>

</html>