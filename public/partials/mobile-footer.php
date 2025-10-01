<?php
$active = $active ?? '';
$isLoggedIn = isset($_SESSION['loggedInUser']);
?>
<footer class="mobile-footer">
    <a href="index.php" class="mobile-nav-item <?= $active==='home'?'is-active':'' ?>">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="trending.php" class="mobile-nav-item <?= $active==='trending'?'is-active':'' ?>">
        <i class="fa-solid fa-fire"></i>
        <span>Trending</span>
    </a>
    <?php if ($isLoggedIn): ?>
    <a href="history.php" class="mobile-nav-item <?= $active==='history'?'is-active':'' ?>">
        <i class="fa-solid fa-history"></i>
        <span>History</span>
    </a>
    <a href="captcha1.php?redirect=upload.php" class="mobile-nav-item <?= $active==='upload'?'is-active':'' ?>">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span>Upload</span>
    </a>
    <a href="channel.php" class="mobile-nav-item <?= $active==='channel'?'is-active':'' ?>">
        <i class="fa-solid fa-user"></i>
        <span>My Channel</span>
    </a>
    <a href="account.php" class="mobile-nav-item <?= $active==='account'?'is-active':'' ?>">
        <i class="fa-solid fa-cog"></i>
        <span>Account</span>
    </a>
    <?php else: ?>
    <a href="captcha1.php?redirect=login.php" class="mobile-nav-item">
        <i class="fa-solid fa-sign-in-alt"></i>
        <span>Login</span>
    </a>
    <?php endif; ?>
</footer>