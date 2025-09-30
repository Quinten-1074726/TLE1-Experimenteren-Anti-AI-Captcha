<?php
require_once './database/connection.php';

// Get video ID from URL
if (!isset($_GET['id'])) {
    die('No video specified.');
}

$videoId = intval($_GET['id']); // prevent SQL injection
$sql = "SELECT * FROM videos WHERE id = $videoId LIMIT 1";

$result = mysqli_query($db, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die('Video not found.');
}

$video = mysqli_fetch_assoc($result);
?>


<html lang="en">

<!-- +1 video view naar de database (als we tijd hebben) -->


<head>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/upload.css">
    <link rel="stylesheet" href="styling/video.css"> <!-- added video specific styles -->
    <title>Document</title>
</head>

<body>
    <?php include "header.php" ?>
    <main id="">
        <div id="flexDezeShitNaarBeneden">
            <video id="video" width="940" height="560" controls>
                <?php
                // Bepaal het juiste pad naar de video
                $filePath = $video['file_path'];
                // Als het pad niet begint met 'uploads/', voeg dan de map toe
                if (strpos($filePath, 'uploads/') !== 0 && strpos($filePath, 'http') !== 0) {
                    $filePath = 'uploads/user-videos/' . $filePath;
                }
                ?>
                <source src="<?= htmlspecialchars($filePath) ?>" type="video/mp4">
            </video>
            <h2> <?= htmlspecialchars($video['video_title']) ?></h2>
            <div id="viewsAndDescription">
                <p><?= htmlspecialchars($video['views']) ?> Views</p>
                <p><?= htmlspecialchars($video['video_description']) ?></p>
            </div>
        </div>
    </main>
</body>

</html>