<?php
require_once '../config/Database.php';

$db = new Database();
$db = $db->connect();

// Sign-up
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if email already exists
        $query = "SELECT user_id FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = "Email already registered.";
        } else {
            // Insert new teacher
            $query = "INSERT INTO users (name, email,phone, password) VALUES ('$name', '$email','$phone', '$password')";
            if (mysqli_query($db, $query)) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-xs p-6 bg-white rounded shadow">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-4">Teacher Sign Up</h2>
            <?php if (isset($error)): ?>
                <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" placeholder="Name" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" placeholder="Phone" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Sign Up</button>
            </form>
            <p class="text-center text-gray-600 mt-4">
                Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login</a>
            </p>
        </div>
    </div>
</body>

</html>