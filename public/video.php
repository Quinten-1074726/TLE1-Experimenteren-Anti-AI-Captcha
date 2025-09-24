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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/video.css">
    <link rel="stylesheet" href="styling/index.css">
    <link rel="stylesheet" href="styling/style.css">
    <title>video</title>
</head>

<body>
    <?php include "header.php" ?>
    <main id="">
        <div id="flexDezeShitNaarBeneden">
        <video id="video" width="940" height="560" controls>
            <source
                src="/TLE1-Experimenteren-Anti-AI-Captcha/public/uploads/user-videos/<?= htmlspecialchars($video['file_path']) ?>"
                type="video/mp4">
        </video>
        <h2> <?= htmlspecialchars($video['video_title']) ?></h2>
        </div>
    </main>
</body>

</html>