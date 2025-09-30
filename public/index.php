<?php
session_start();
require_once 'database/connection.php';
require_once __DIR__ . '/app/video_filter.php';


$s = $_GET['s'] ?? '';
$videos = filter_videos($db, $s, 60);
?>


<!doctype html>
<html lang="en">
<head>
    <?php include "defaultsettings.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StreamHub</title>

    
    <link rel="stylesheet" href="styling/header.css">
    <link rel="stylesheet" href="styling/index.css">

    <!-- PHP en JS includes-->
    <script>
      const videos = <?= json_encode($videos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>
    <script src="javascript/index.js" defer></script>
    <script src="javascript/search.js" defer></script>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,800&display=swap"
      rel="stylesheet">
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
            <input type="checkbox">
            <span class="slider round"></span>
          </span>
        </label>
      </div>

      <a href="index.php">Home</a>
      <a href="trending.php">Trending</a>
      <?php if (isset($_SESSION['loggedInUser'])): ?>
        <a href="channel.php">My channel</a>
        <a href="captcha1.php?redirect=upload.php" class="btn">Video uploaden</a>
      <?php else: ?>
        <a href="captcha1.php?redirect=login.php">Login</a>
        <a href="captcha1.php?redirect=register.php">Register</a>
      <?php endif; ?>
    </div>


  </div>

  <!-- right -->
  <div class="flex_right_side">
    <div class="right_side"></div>
  </div>
</main>

</body>
</html>
