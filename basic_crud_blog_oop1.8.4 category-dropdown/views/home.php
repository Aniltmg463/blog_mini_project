<?php

// require_once __DIR__ . '/../models/CategoryModel.php';
// $categoryModel = new CategoryModel();
// $categories = $categoryModel->getAllCategories();

include 'layout/header.php';


echo "<h1 class='text-center'>Home Page</h1>";
?>

<div class="container mt-5">
    <?php if (isset($_SESSION['email'])): ?>
    <div class="alert alert-primary text-center">
        Welcome: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong>
    </div>
    <?php endif; ?>