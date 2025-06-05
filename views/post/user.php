<?php
session_start();
require_once __DIR__ . '/../../controllers/PostController.php';
require_once __DIR__ . '/../../controllers/CategoryController.php';


$userEmail = $_SESSION['user_email'] ?? null;
$userRole = $_SESSION['user_role'] ?? 'Guest';

// Instantiate controllers
$postController = new PostController();
$categoryController = new CategoryController();

// Get all categories
$categories = $categoryController->getAllCategories();

// Get selected category ID from GET request
$selectedCategoryId = $_GET['category'] ?? '';

// Fetch posts based on selected category
$posts = !empty($selectedCategoryId)
    ? $postController->getPostsByCategory($selectedCategoryId)
    : $postController->read();
?>

<?php include '../layout/header.php'; ?>

<!-- Bootstrap 5 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="container py-5">

    <?php if ($userEmail): ?>
    <div class="alert alert-info text-center">
        Welcome: <strong><?= htmlspecialchars($userEmail) ?></strong> | Role:
        <strong><?= htmlspecialchars($userRole) ?></strong>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">All Posts</h2>
        <?php if ($userEmail): ?>
        <a class="btn btn-danger btn-sm" href="../../auth/logout.php">🚪 Logout</a>
        <?php endif; ?>
    </div>

    <!-- Category Filter Form -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="category" class="form-label fw-bold">Filter by Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" id="category" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= $selectedCategoryId == $category['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
            </div>
        </div>
    </form>

    <?php if (isset($_SESSION['msg'])): ?>
    <div class="message">
        <?= $_SESSION['msg'];
            unset($_SESSION['msg']); ?>
    </div>
    <?php endif; ?>

    <?php if ($userEmail): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="../../index.php?action=create" class="btn btn-success btn-sm">➕ Add New Post</a>
    </div>
    <?php endif; ?>

    <?php if (!empty($posts) && is_array($posts)): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped bg-white shadow rounded">
            <thead class="table-dark">
                <tr>
                    <th width="5%">#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Date</th>
                    <th>Posted By</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($posts as $index => $post): ?>
                <tr>
                    <td><?= $post['post_id'] ?></td>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($post['body'])) ?></td>
                    <td><?= htmlspecialchars($post['date']) ?></td>
                    <td><?= htmlspecialchars($post['user_name']) ?></td>
                    <td>

                        <a href="../../index.php?action=view&id=<?= $post['post_id'] ?>"
                            class="btn btn-sm btn-primary">View</a>



                        <?php if ($_SESSION['user_id'] == $post['user_id']): ?>

                        <a href="../../index.php?action=edit&id=<?= $post['post_id'] ?>"
                            class="btn btn-sm btn-primary">✏️ Edit</a>
                        <a href="../../?action=delete&id=<?= $post['post_id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-warning text-center">No posts found.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HoA9+Ph3sGGyC22sBKljN5pT0zg+HgMD9gNopOEowTxQ8AenxR0bK25NzF8z6c4N" crossorigin="anonymous">
</script>