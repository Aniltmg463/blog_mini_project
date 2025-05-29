<form method="post" action="?action=edit&id=<?= $data['post_id'] ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?= $data['title'] ?>" placeholder="Enter Title"><br>
    <label>Content:</label>
    <textarea name="body" placeholder="Text Area" Test Area><?= $data['body'] ?></textarea><br>
    <label>Date:</label>
    <input type="date" name="date"><br><br>
    <button type="submit">Update</button>
</form>