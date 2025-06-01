<?php session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-xs p-6 bg-white rounded shadow">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-4">Student Login</h2>


            <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-red-500 text-center mb-4">
                <?php
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']); // Clear message after displaying
                    ?>
            </p>
            <?php endif; ?>


            <form method="POST" action="login-process.php">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Login</button>
            </form>
            <p class="text-center text-gray-600 mt-4">
                Don't have an account? <a href="signup.php" class="text-blue-500 hover:underline">Sign up</a>
            </p>
        </div>
    </div>
</body>

</html>