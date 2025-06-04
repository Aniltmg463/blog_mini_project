<?php
include 'views/layout/header.php';

require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/PostModel.php';

define('UPLOADS_PATH', 'Uploads/');

$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

$selectedCategoryId = $_GET['category'] ?? '';

// Fetch all posts or by category
$postModel = new PostModel();
$posts = !empty($selectedCategoryId)
    ? $postModel->getPostsByCategory($selectedCategoryId)
    : $postModel->getAllPosts();
?>

<!-- Bootstrap 5 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Category Filter Form -->
<div class="container mt-4">
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="category" class="form-label fw-bold">Filter by Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" id="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_id']) ?>"
                        <?= $selectedCategoryId == $category['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>
</div>

<!-- Blog Post Cards -->
<div class="container py-4">
    <div class="row g-4">
        <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border border-primary border-2">
                <!-- Debug image field -->
                <!-- <p>Image: <?= htmlspecialchars($post['image'] ?? 'Not set') ?></p> -->

                <!-- Image handling -->
                <?php if (!empty($post['image'])): ?>
                <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top"
                    alt="<?= htmlspecialchars($post['title']) ?>" style="height: 400px; object-fit: cover;"
                    loading="lazy" onerror="this.src='<?= UPLOADS_PATH ?>placeholder-image.jpg'">
                <?php else: ?>
                <img src="<?= UPLOADS_PATH ?>placeholder-image.jpg" class="card-img-top" alt="Placeholder Image"
                    style="height: 200px; object-fit: cover;" loading="lazy">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title text-truncate"><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="card-text small"><?= nl2br(htmlspecialchars(substr($post['body'], 0, 120))) ?>...</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted"><?= htmlspecialchars($post['date']) ?> by
                        <?= htmlspecialchars($post['user_name']) ?></small>
                    <a href="?action=view&id=<?= $post['post_id'] ?>" class="btn btn-sm btn-primary">Read More</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center">
                No posts found.
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">Back to Homepage</a>
    </div>
</div>

<!-- Bootstrap JS Bundle (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HoA9+Ph3sGGyC22sBKljN5pT0zg+HgMD9gNopOEowTxQ8AenxR0bK25NzF8z6c4N" crossorigin="anonymous">
</script>