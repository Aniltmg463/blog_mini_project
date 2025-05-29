<?php

include 'layout/header.php';
?>

<?php if (isset($_SESSION['email'])): ?>
<p class="text-red-500 text-center mb-4">
    <?php
        echo "Welcome" . " : " . $_SESSION['email'];
        // unset($_SESSION['email']);
        ?>
</p>
<?php endif; ?>


<a href="?action=create">Add New Post</a>

<?php if (!empty($posts) && is_array($posts)): ?>
<?php foreach ($posts as $p): ?>
<h2><?= $p['title'] ?></h2>
<p><?= $p['body'] ?></p>
<small>Posted on: <?= $p['date'] ?></small><br>
<p>Posted By: <?= $p['user_name'] ?></p>

<a href="?action=edit&id=<?= $p['post_id'] ?>">Edit</a> |
<a href="?action=delete&id=<?= $p['post_id'] ?>" onclick="return confirm('Delete?')">Delete</a>
<hr>
<?php endforeach; ?>
<?php else: ?>
<p>No posts found.</p>
<?php endif; ?>