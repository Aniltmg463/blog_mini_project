<?php include 'views/layout/header.php'; ?>
<div class="container py-5">
    <div class="mb-4">
        <?php if (!isset($_SESSION['user_email'])): ?>
        <a href="index.php" class="btn btn-secondary">← Back to Posts</a>
        <?php else: ?>
        <a href="views/post/user.php" class="btn btn-secondary">← Back to Posts</a>
        <?php endif; ?>
    </div>


    <?php if ($postDetails): ?>
    <div class="card shadow">
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
    <div class="alert alert-danger">Post not found.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>