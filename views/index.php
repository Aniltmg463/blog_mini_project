<?php
include 'layout/header.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/PostModel.php';

$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

$selectedCategoryId = $_GET['category'] ?? '';

$postModel = new PostModel();

// Fetch all posts or by category
$allPosts = !empty($selectedCategoryId)
    ? $postModel->getPostsByCategory($selectedCategoryId)
    : $postModel->getAllPosts();

// Limit displayed posts to 4
$displayPosts = array_slice($allPosts, 0, 4);
?>

<!-- Bootstrap 5 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Category Filter -->
<div class="container mt-4">
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="category" class="form-label fw-bold">Filter by Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>"
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
        <?php if (!empty($displayPosts)): ?>
            <?php foreach ($displayPosts as $post): ?>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <!-- Add image to the card -->
                        <?php if (!empty($post['image'])): ?>
                            <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($post['title']) ?>" style="height: 400px; object-fit: cover;"
                                loading="lazy" onerror="this.src='path/to/placeholder-image.jpg'">
                        <?php else: ?>
                            <img src="path/to/placeholder-image.jpg" class="card-img-top" alt="Placeholder Image"
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
                <div class="alert alert-warning text-center">No posts found.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- View All Button -->
    <?php if (count($allPosts) > 4): ?>
        <div class="text-center mt-4">
            <a href="index.php?action=viewAll<?= !empty($selectedCategoryId) ? '?category=' . $selectedCategoryId : '' ?>"
                class="btn btn-outline-secondary">
                View All Posts
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>