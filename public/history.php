<?php
require_once 'database/connection.php';

/** @var mysqli $db */
session_start();

$videos = [];

// Alleen de history ophalen als de gebruiker is ingelogd
if (isset($_SESSION['loggedInUser'])) {
    $sql = "SELECT * FROM history ORDER BY id DESC";
    $result = mysqli_query($db, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $videos[] = $row;
        }
    } else {
        die("Query failed: " . mysqli_error($db));
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php include "defaultsettings.php" ?>
      <script>
        // json flags om speciale characters niet code te laten breken
        const videos = <?php echo json_encode($videos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        console.log(videos);
    </script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>History</title>

    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="styling/index.css">


    <script src="javascript/index.js"></script>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=SUSE+Mono:ital,wght@0,100..800;1,100..800&display=swap"
        rel="stylesheet">
</head>

<body>

<?php include "header.php" ?>

<main>
    <?php $active='home'; $showAiFilter=true; include './partials/sidebar.php'; ?>
    <!-- right -->
    <div class="flex_right_side">
        <div class="right_side">
            <?php if (isset($_SESSION['loggedInUser'])): ?>
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="history-message"Je hebt nog geen bekeken video in je geschiedenis.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="history-message">Je moet inloggen om je geschiedenis te zien.</p>
            <?php endif; ?>

        </div>
    </div>
</main>

<footer>
</footer>

</body>
</html>

<?php $active='history'; include './partials/mobile-footer.php'; ?>
