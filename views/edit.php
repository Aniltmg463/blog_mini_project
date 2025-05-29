<form method="post" action="?action=edit&id=<?= $data['id'] ?>">
    <input type="text" name="title" value="<?= $data['title'] ?>"><br>
    <textarea name="body"><?= $data['body'] ?></textarea><br>
    <button type="submit">Update</button>
</form>