<?php include 'views/layout/header.php'; ?>

<div class="container mt-5">
    <?php if ($post): ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($post->title) ?></h2>
            <p class="card-subtitle text-muted mb-2">
                Posted on <?= htmlspecialchars($post->date) ?>
                <?php if (!empty($post->user_name)): ?>
                by <?= htmlspecialchars($post->user_name) ?>
                <?php endif; ?>
            </p>
            <hr>
            <p class="card-text"><?= nl2br(htmlspecialchars($post->body)) ?></p>
            <a href="index.php" class="btn btn-secondary mt-3">← Back to Posts</a>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger">
        Post not found.
    </div>
    <?php endif; ?>
</div>

<?php include 'views/layout/footer.php'; ?>