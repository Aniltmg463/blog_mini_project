<?php

include 'layout/header.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/PostModel.php';

$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

$selectedCategoryId = $_GET['category'] ?? '';

// Fetch posts based on selected category
$postModel = new PostModel();
if (!empty($selectedCategoryId)) {
    $posts = $postModel->getPostsByCategory($selectedCategoryId);
} else {
    $posts = $postModel->getAllPosts();
}

?>

<!-- Bootstrap 5 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<!-- Category Filter Form -->
<div class="container mt-4">
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="category" class="form-label fw-bold">Filter by Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" id="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= $selectedCategoryId == $category['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>
</div>


<div class="container py-5">
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
                <?php foreach ($posts as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($p['body'])) ?></td>
                    <td><?= htmlspecialchars($p['date']) ?></td>
                    <td><?= htmlspecialchars($p['user_name']) ?></td>
                    <td>
                        <a href="?action=view&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-primary"> view</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-warning text-center">
        No posts found.
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS Bundle (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HoA9+Ph3sGGyC22sBKljN5pT0zg+HgMD9gNopOEowTxQ8AenxR0bK25NzF8z6c4N" crossorigin="anonymous">
</script>