<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php if (isset($_SESSION['email'])): ?>
    <div class="text-end m-3">
        <a href="auth/logout.php" class="btn btn-sm btn-warning">Log Out</a>
    </div>
    <?php endif; ?>

</head>

<body>
    <div class="container mt-4">