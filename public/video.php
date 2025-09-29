<?php


require_once 'database/connection.php';

$videoID = $_GET['id'];
//input validatie
$videoID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!isset($videoID)) {
    header("Location: ./index.php");
    exit;
}

$sql = "SELECT * FROM videos WHERE id = $videoID";
$result = mysqli_query($db, $sql);

if ($result) {
    $video = mysqli_fetch_assoc($result);
} else {
    die("Query failed: " . mysqli_error($db));
}

?>

<html lang="en">

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
        </div>
    </main>
</body>

</html>