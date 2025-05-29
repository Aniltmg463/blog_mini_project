<!-- <form method="post" action="?action=create">
    <input type="text" name="title" placeholder="Title"><br>
    <textarea name="body" placeholder="Content"></textarea><br>
    <button type="submit">Create</button>
</form> -->

<!-- views/create.php -->

<?php
require_once 'config/Database.php';

$db = new Database();
$conn = $db->connect();

$email = $_SESSION['email']; // make sure session is set

$query = "SELECT user_id, name FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// echo "Welcome, " . $user['name'] . " (User ID: " . $user['user_id'] . ")";
?>


<h2>Create New Post</h2>

<form method="post" action="?action=create">
    <label>Title:</label><br>
    <input type="text" name="title" placeholder="Post Title" required><br><br>

    <label>Body:</label><br>
    <textarea name="body" placeholder="Post Content" required></textarea><br><br>

    <label>Date:</label><br>
    <input type="date" name="date" required><br><br>

    <label>User ID:</label><br>
    <input type="text" name="userid" value="<?php echo $user['user_id'] ?>" readonly><br><br>

    <button type="submit">Create Post</button>
</form>