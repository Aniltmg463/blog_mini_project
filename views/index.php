<?php include 'layout/header.php';
?>

<!-- Bootstrap 5 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="container py-5">
    <?php if (isset($_SESSION['email'])): ?>
    <div class="alert alert-info text-center">
        Welcome: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['email'])): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">All Posts</h2>
        <a href="?action=create" class="btn btn-success btn-sm">➕ Add New Post</a>
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
                <?php foreach ($posts as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($p['body'])) ?></td>
                    <td><?= htmlspecialchars($p['date']) ?></td>
                    <td><?= htmlspecialchars($p['user_name']) ?></td>
                    <td>
                        <a href="?action=view&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-primary"> view</a>


                        <?php if (isset($_SESSION['email'])): ?>
                        <a href="?action=edit&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-primary">✏️ Edit</a>
                        <a href="?action=delete&id=<?= $p['post_id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                        <?php endif; ?>
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