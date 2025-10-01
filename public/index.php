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
    <link rel="stylesheet" href="styling/index.css">

    <script src="javascript/index.js" defer></script>
    <script src="javascript/search.js" defer></script>
</head>
<body>

<?php include "header.php" ?>

<main>
  <?php $active='home'; $showAiFilter=true; include './partials/sidebar.php'; ?>
  <!-- right -->
  <div class="flex_right_side">
    <div class="right_side"></div>
  </div>
</main>

<?php include './partials/mobile-footer.php'; ?>

</body>
</html>
