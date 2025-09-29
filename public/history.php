<?php
session_start(); // start sessie
require_once 'database/connection.php';

/** @var mysqli $db */

// Alleen history ophalen als er een ingelogde gebruiker is
$videos = [];
if (isset($_SESSION['loggedInUser'])) {
    $sql = "SELECT * FROM history ORDER BY id DESC";
    $result = mysqli_query($db, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $videos[] = $row;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="styling/index.css">
    <link rel="stylesheet" href="styling/style.css">
</head>
<body>

<?php include "header.php" ?>

<main style="display:flex; justify-content:center; align-items:center; height:80vh;">
    <?php if (isset($_SESSION['loggedInUser'])): ?>
        <div>
            <h1>Your Video History</h1>
            <?php foreach ($videos as $video): ?>
                <div>
                    <p><?= htmlspecialchars($video['video_title']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div>
            <h2>Je moet ingelogd zijn om je video history te zien.</h2>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
