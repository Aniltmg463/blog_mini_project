<!-- <form method="post" action="?action=create">
    <input type="text" name="title" placeholder="Title"><br>
    <textarea name="body" placeholder="Content"></textarea><br>
    <button type="submit">Create</button>
</form> -->

<!-- views/create.php -->
<h2>Create New Post</h2>

<form method="post" action="?action=create">
    <label>Title:</label><br>
    <input type="text" name="title" placeholder="Post Title" required><br><br>

    <label>Body:</label><br>
    <textarea name="body" placeholder="Post Content" required></textarea><br><br>

    <label>Date:</label><br>
    <input type="date" name="date" required><br><br>

    <button type="submit">Create Post</button>
</form>