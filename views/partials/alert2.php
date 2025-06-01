<?php if (isset($_SESSION['alert'])): ?>
<div id="alert-box"
    class="alert alert-<?php echo $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show"
    role="alert">
    <?php echo htmlspecialchars($_SESSION['alert']['message']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
setTimeout(function() {
    const alertBox = document.getElementById('alert-box');
    if (alertBox) {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
        bsAlert.close();
    }
}, 3000);
</script>
<?php unset($_SESSION['alert']); ?>
<?php endif; ?>