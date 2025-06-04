<?php
// Make sure to fetch post data before this file is rendered
// $data = ['post_id' => ..., 'title' => ..., 'body' => ..., 'date' => ...];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Post</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="mb-4 text-center">Edit Blog Post</h2>

        <form method="post" action="?action=edit&id=<?= $data['post_id'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-control"
                    value="<?= htmlspecialchars($data['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Content:</label>
                <textarea id="body" name="body" class="form-control"
                    required><?= htmlspecialchars($data['body']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= $data['date'] ?>" required>
            </div>

            <!-- <div class="mb-3">
                <img src="<?php echo $item['file']; ?>" alt="file" class="img-thumbnail mb-2" style="height: 80px;">
                <label for="file" class="form-label">Add Image <span class="text-danger">*</span></label>
                <input type="file" name="file" id="file" class="form-control">
            </div> -->

            <div class="mb-3">
                <?php if (!empty($data['image'])): ?>
                <img src="<?= htmlspecialchars($data['image']) ?>" alt="file" class="img-thumbnail mb-2"
                    style="height: 80px;">
                <?php endif; ?>
                <label for="file" class="form-label">Add Image <span class="text-danger">*</span></label>
                <input type="file" name="file" id="file" class="form-control">
            </div>




            <div class="text-end">
                <button type="submit" class="btn btn-success">Update Post</button>
            </div>
        </form>
    </div>

    <!-- jQuery -->
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