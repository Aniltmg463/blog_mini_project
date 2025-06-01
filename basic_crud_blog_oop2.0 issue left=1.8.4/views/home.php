<?php

// require_once __DIR__ . '/../models/CategoryModel.php';
// $categoryModel = new CategoryModel();
// $categories = $categoryModel->getAllCategories();

include 'layout/header.php';
require_once __DIR__ . '/../models/post_model.php';

$postmodel = new post_model();
$posts = $postmodel->read();

// echo "<h1 class='text-center'>Home Page</h1>";
?>

<h1 class="text-center mt-4">Home Page</h1>

<div class="container mt-5">
    <?php if (isset($_SESSION['email'])): ?>
    <div class="alert alert-primary text-center">
        Welcome: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong>
    </div>
    <?php endif; ?>
</div>

<section class="container mt-4">
    <h2 class="text-center mb-4">Latest Posts</h2>

    <div class="row">
        <?php if (!empty($posts)) : ?>
        <?php foreach ($posts as $post): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Author: <?= htmlspecialchars($post['user_name']) ?></h6>
                    <p class="card-text"><?= substr(htmlspecialchars($post['body']), 0, 150) ?>...</p>
                    <div class="mt-auto">
                        <a href="view_post.php?post_id=<?= $post['post_id'] ?>" class="btn btn-sm btn-primary">Read
                            more</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <p class="text-center">No posts found.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'layout/footer.php'; ?>