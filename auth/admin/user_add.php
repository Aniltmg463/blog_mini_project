<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <style>
    body {
        font-family: Arial;
        padding: 20px;
    }

    form {
        width: 300px;
        margin: auto;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0 15px;
    }

    input[type="submit"] {
        padding: 8px 16px;
        cursor: pointer;
    }

    .message {
        color: red;
        margin-bottom: 15px;
        text-align: center;
    }
    </style>
</head>

<body>

    <h2>Add User</h2>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="message">
        <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="../../index.php?action=user_add">
        <label for="name">Full Name:</label>
        <input type="text" name="name" required placeholder="Enter full name">

        <label for="email">Email:</label>
        <input type="email" name="email" required placeholder="Enter email">

        <label for="password">Password:</label>
        <input type="password" name="password" required placeholder="Enter password">
        <div class="mb-4">
            <label class="block text-gray-700">Select Role</label>
            <select name="role" class="w-full p-2 border rounded" required>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" value="Add User">
    </form>

    <p class="text-center text-gray-600 mt-4">
        Back to home <a href="admin_dashboard.php" class="text-blue-500 hover:underline">Sign up</a>
    </p>

</body>

</html>