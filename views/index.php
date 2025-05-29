<a href="?action=create">Add New Post</a>

<?php if (!empty($posts) && is_array($posts)): ?>
    <?php foreach ($posts as $p): ?>
        <h2><?= $p['title'] ?></h2>
        <p><?= $p['body'] ?></p>
        <small>Posted on: <?= $p['date'] ?></small><br>
        <a href="?action=edit&id=<?= $p['post_id'] ?>">Edit</a> |
        <a href="?action=delete&id=<?= $p['post_id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>