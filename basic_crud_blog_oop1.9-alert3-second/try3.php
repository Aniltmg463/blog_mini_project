<?php
// Start session to use $_SESSION
session_start();
require_once 'views/partials/alert2.php';
// Optional: Set a sample alert to test

// Remove or modify this as needed
if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => 'success', // or 'danger'
        'message' => 'This is a test alert message!'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bootstrap Alert Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>