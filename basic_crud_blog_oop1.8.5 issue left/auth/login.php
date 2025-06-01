<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
    body {
        font-family: Arial;
        padding: 20px;
    }

    form {
        width: 300px;
        margin: auto;
    }

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

    <h2>Login</h2>

    <?php if (isset($_SESSION['msg'])): ?>
    <div class="message">
        <?= $_SESSION['msg'];
            unset($_SESSION['msg']); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="auth/login-process.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required placeholder="Enter email">

        <label for="password">Password:</label>
        <input type="password" name="password" required placeholder="Enter password">

        <input type="submit" value="Login">
    </form>
    <p class="text-center text-gray-600 mt-4">
        Don't have an account? <a href="signup.php" class="text-blue-500 hover:underline">Sign up</a>
    </p>
</body>

</html>