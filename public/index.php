<?php
session_start();
require_once 'database/connection.php';
?>
<!doctype html>
<html lang="en">
<head>
    <?php include "defaultsettings.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamHub</title>

    <link rel="stylesheet" href="styling/header.css">
    <link rel="stylesheet" href="styling/index.css">

    <script src="javascript/index.js" defer></script>
    <script src="javascript/search.js" defer></script>
</head>
<body>

<?php include "header.php" ?>

<main>
  <!-- left -->
  <div class="left_side">
    <div>
      <div>
        <label id="ai_filter_label">
          AI Filter
          <span class="switch">
            <input type="checkbox" id="ai_filter">
            <span class="slider round"></span>
          </span>
        </label>
      </div>

      <a href="index.php">Home</a>
      <a href="trending.php">Trending</a>
      <a>Subcriptions</a>

      <?php if (isset($_SESSION['loggedInUser'])): ?>
        <a href="channel.php">My channel</a>
        <a href="upload.php" class="btn">Video uploaden</a>
        <a href="account.php?id=<?= $_SESSION['loggedInUser']['id'] ?>">Account</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="captcha1.php?redirect=login.php">Login</a>
        <a href="captcha1.php?redirect=register.php">Register</a>
      <?php endif; ?>
    </div>

    <div>
      <!-- channels here -->
      <a>channel 1</a>
      <a>channel 123</a>
    </div>
  </div>

  <!-- right -->
  <div class="flex_right_side">
    <div class="right_side"></div>
  </div>
</main>

</body>
</html>
