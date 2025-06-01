<?php
include 'layout/header.php';
require_once __DIR__ . '/../models/post_model.php';

$postModel = new post_model();
$posts = $postModel->read();

$user_id = null;
if (isset($_SESSION['email'])) {
    $user = $postModel->getUserByEmail($_SESSION['email']);
    $user_id = $user['user_id'];
}
?>

<h1 class="text-center mt-4">Home Page</h1>

<div class="container mt-5">
    <?php if (isset($_SESSION['email'])): ?>
    <div class="alert alert-primary text-center">
        Welcome: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong>
    </div>
    <?php endif; ?>
</div>

<section class="posts-container container mt-4">
    <h2 class="heading text-center mb-4">Latest Posts</h2>

    <div class="row">
        <?php if (!empty($posts)) : ?>
        <?php foreach (array_slice($posts, 0, 6) as $post) :
                $post_id = $post['post_id'];

                $total_comments = $postModel->getCommentCount($post_id);
                $total_likes = $postModel->getLikeCount($post_id);
                $liked = $user_id ? $postModel->isPostLikedByUser($post_id, $user_id) : false;
            ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($post['user_name'] ?? 'Unknown') ?> |
                        <?= $post['date'] ?></h6>
                    <p class="card-text"><?= substr(htmlspecialchars($post['body']), 0, 150) ?>...</p>
                    <div class="mt-auto">
                        <a href="view_post.php?post_id=<?= $post_id ?>" class="btn btn-sm btn-primary">Read more</a>
                        <span class="badge bg-info ms-2"><i class="fas fa-comment"></i> <?= $total_comments ?></span>
                        <span class="badge bg-danger ms-2">
                            <i class="fas fa-heart" style="<?= $liked ? 'color:red;' : '' ?>"></i> <?= $total_likes ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <p class="text-center">No posts added yet!</p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="posts.php" class="btn btn-outline-secondary">View All Posts</a>
    </div>
</section>

<?php include 'layout/footer.php'; ?>