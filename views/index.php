<?php include 'layout/header.php'; ?>

<div class="container mt-5">
    <?php if (isset($_SESSION['email'])): ?>
    <div class="alert alert-primary text-center">
        Welcome: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">All Posts</h2>
        <a href="?action=create" class="btn btn-success">➕ Add New Post</a>
    </div>

    <?php if (!empty($posts) && is_array($posts)): ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($posts as $p): ?>
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?= htmlspecialchars($p['title']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($p['body'])) ?></p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted">📅 <?= htmlspecialchars($p['date']) ?></small><br>
                    <small class="text-muted">👤 Posted By: <?= htmlspecialchars($p['user_name']) ?></small><br>
                    <div class="mt-2">
                        <a href="?action=edit&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-outline-primary">✏️
                            Edit</a>
                        <a href="?action=delete&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-warning text-center">
        No posts found.
    </div>
    <?php endif; ?>
</div>