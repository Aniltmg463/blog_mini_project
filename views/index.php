<a href="?action=create">Add New Post</a>
<?php foreach ($posts as $p): ?>
    <h2><?= $p['title'] ?></h2>
    <p><?= $p['body'] ?></p>
    <a href="?action=edit&id=<?= $p['id'] ?>">Edit</a> |
    <a href="?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    <hr>
<?php endforeach; ?>