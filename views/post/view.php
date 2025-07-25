<?php include 'views/layout/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?= isset($_SESSION['user_email']) ? 'views/post/user.php' : 'index.php' ?>"
            class="btn btn-outline-secondary">
            ← Back to Posts
        </a>
    </div>

    <?php if ($postDetails): ?>

    <div class="card shadow mb-4">
        <?php if (!empty($postDetails['image'])): ?>
        <img src="<?= htmlspecialchars($postDetails['image']) ?>" alt="Post Image" class="card-img-top img-fluid"
            style="width: 70%; height: auto; display: block; margin: 0 auto;">
        <?php endif; ?>
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($postDetails['title']) ?></h2>
            <p class="text-muted mb-2">
                Posted on <?= date('F j, Y', strtotime($postDetails['date'])) ?>
            </p>
            <hr>
            <div class="card-text">
                <?= nl2br($postDetails['body']) ?>
            </div>
        </div>
    </div>



    <?php else: ?>
    <div class="alert alert-danger mt-4">Post not found.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>