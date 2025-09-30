<?php
$active = $active ?? '';
$showAiFilter = $showAiFilter ?? false;
$isLoggedIn = isset($_SESSION['loggedInUser']);
?>
<aside class="sidebar" role="navigation" aria-label="Zijbalk">
  <?php if ($showAiFilter): ?>
    <div class="sidebar__section">
      <div class="sidebar__heading">Filters</div>
      <label class="ai-filter" for="ai_filter">
        <span>AI-filter</span>
        <span class="switch">
          <input type="checkbox" id="ai_filter">
          <span class="slider round"></span>
        </span>
      </label>
    </div>
  <?php endif; ?>

  <nav class="sidebar__section">
    <div class="sidebar__heading">Navigatie</div>

    <a href="index.php"
       class="nav-item <?= $active==='home'?'is-active':'' ?>"
       <?= $active==='home'?'aria-current="page"':'' ?>>
      <i class="fa-solid fa-house nav-icon" aria-hidden="true"></i>
      <span>Home</span>
    </a>

    <a href="trending.php"
       class="nav-item <?= $active==='trending'?'is-active':'' ?>"
       <?= $active==='trending'?'aria-current="page"':'' ?>>
      <i class="fa-solid fa-fire nav-icon" aria-hidden="true"></i>
      <span>Trending</span>
    </a>
  </nav>

  <?php if ($isLoggedIn): ?>
    <div class="sidebar__section">
      <div class="sidebar__heading">Bibliotheek</div>

      <a href="channel.php"
         class="nav-item <?= $active==='mychannel'?'is-active':'' ?>"
         <?= $active==='mychannel'?'aria-current="page"':'' ?>>
        <i class="fa-solid fa-user nav-icon" aria-hidden="true"></i>
        <span>My channel</span>
      </a>

      <a href="index.php" class="nav-item">
        <i class="fa-solid fa-clock-rotate-left nav-icon" aria-hidden="true"></i>
        <span>History</span>
      </a>
    </div>

    <div class="sidebar__section">
      <a href="upload.php" class="btn-upload">
        <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
        <span>Video uploaden</span>
      </a>

      <a href="account.php?id=<?= $_SESSION['loggedInUser']['id'] ?>" class="nav-item">
        <i class="fa-solid fa-id-card nav-icon" aria-hidden="true"></i>
        <span>Account</span>
      </a>

      <a href="logout.php" class="nav-item">
        <i class="fa-solid fa-right-from-bracket nav-icon" aria-hidden="true"></i>
        <span>Logout</span>
      </a>
    </div>
  <?php else: ?>
    <div class="sidebar__section">
      <div class="sidebar__heading">Account</div>

      <a href="captcha1.php?redirect=login.php" class="nav-item">
        <i class="fa-solid fa-right-to-bracket nav-icon" aria-hidden="true"></i>
        <span>Login</span>
      </a>

      <a href="captcha1.php?redirect=register.php" class="nav-item">
        <i class="fa-solid fa-user-plus nav-icon" aria-hidden="true"></i>
        <span>Register</span>
      </a>
    </div>
  <?php endif; ?>
</aside>
