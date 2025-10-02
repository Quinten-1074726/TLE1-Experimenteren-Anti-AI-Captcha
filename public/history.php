<?php
require_once 'database/connection.php';
session_start();

/** @var mysqli $db */
$videos = [];

// Alle history-video's ophalen, ongeacht gebruiker
$sql = "SELECT * FROM history ORDER BY id DESC";
$result = mysqli_query($db, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $videos[] = $row;
    }
} else {
    die("Query failed: " . mysqli_error($db));
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include "defaultsettings.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamHub - History</title>
    <link rel="stylesheet" href="styling/index.css">
    
    <script src="javascript/search.js" defer></script>
</head>
<body>

<?php include "header.php"; ?>

<main>
    <?php 
        $active = 'history'; 
        $showAiFilter = true; 
        include './partials/sidebar.php'; 
    ?>

    <div class="flex_right_side">
        <div class="right_side">
            <?php if (!empty($videos)): ?>
                <?php foreach ($videos as $video): ?>
                    <div class="vid-card">
                        <a href="./video.php?id=<?= htmlspecialchars($video['id']) ?>">
                            <img class="thumb-img" 
                                 src="<?= !empty($video['thumbnail']) ? 'uploads/user-thumbnails/' . htmlspecialchars($video['thumbnail']) : 'uploads/default-thumbnail.jpg' ?>" 
                                 alt="<?= htmlspecialchars($video['video_title']) ?>">
                        </a>
                        <h2><?= htmlspecialchars($video['video_title']) ?></h2>
                        <p><?= htmlspecialchars($video['channel_name']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Geen resultaten gevonden</h3>
                    <p>Er zijn geen video's in je geschiedenis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include './partials/mobile-footer.php'; ?>

</body>
</html>