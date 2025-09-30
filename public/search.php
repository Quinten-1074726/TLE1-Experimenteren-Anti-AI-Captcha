<?php
session_start();
require_once 'database/connection.php';

/** @var mysqli $db */

// Fetch optional search term (supports both GET or POST 'q')
$rawSearch = '';
    if (isset($_POST['q'])) {
    $rawSearch = trim($_POST['q']);
} else {
    $rawSearch = '';
}

// Single prepared statement; empty search returns all (LIKE '%%')
$like = '%' . $rawSearch . '%';
$stmt = $db->prepare("SELECT * FROM videos WHERE video_title LIKE ? ORDER BY id DESC");
if (!$stmt) {
    die('Prepare failed: ' . $db->error);
}
$stmt->bind_param('s', $like);
$stmt->execute();
$result = $stmt->get_result();

$videos = [];
while ($row = $result->fetch_assoc()) {
    $videos[] = $row;
}
$stmt->close();






?>


<?php
// No need to inject all videos into JS for this page; we'll render server-side.
?>


<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styling/index.css">
    <link rel="stylesheet" href="styling/style.css">
    <!-- Search page renders results server-side; no index.js pagination here -->
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=SUSE+Mono:ital,wght@0,100..800;1,100..800&display=swap"
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
                            <input type="checkbox" name="ai_filter" id="ai_filter" value="1">
                            <span class="slider round"></span>
                        </span>
                    </label>
                </div>

                <a href="index.php">Home</a>
                <a href="trending.php">Trending</a>
                <a>Subcriptions</a>
                <a href="channel.php">My channel</a>

                <?php if (isset($_SESSION['loggedInUser'])): ?>
                    <a href="upload.php" class="btn">Video uploaden</a>
                    <a href="account.php?id=<?= $_SESSION['loggedInUser']['id'] ?>">Account</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
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
            <div class="right_side">
                <?php
                $termDisplay = htmlspecialchars($rawSearch ?? '', ENT_QUOTES, 'UTF-8');
                if ($termDisplay !== '') {
                    echo '<h2 style="margin-top:0">Zoekresultaten voor: <em>' . $termDisplay . '</em></h2>';
                } else {
                    echo '<h2 style="margin-top:0">Alle videos</h2>';
                }
                if (empty($videos)) {
                    echo '<p>Geen videos gevonden.</p>';
                } else {
                    echo '<div style="display:flex;flex-wrap:wrap;">';
                    foreach ($videos as $v) {
                        $id = (int)$v['id'];
                        $title = htmlspecialchars($v['video_title'], ENT_QUOTES, 'UTF-8');
                        $channel = htmlspecialchars($v['channel_name'] ?? '', ENT_QUOTES, 'UTF-8');
                        $thumbRaw = $v['thumbnail'];
                        // If blob stores filename bytes (e.g. "12.png"), cast to string
                        if (!is_string($thumbRaw)) {
                            $thumb = '';
                            if (is_resource($thumbRaw)) { $thumb = ''; }
                            else { $thumb = ''; }
                        } else {
                            $thumb = $thumbRaw; // assumed filename
                        }
                        $thumbEsc = htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8');
                        echo '<div style="display:flex;flex-direction:column;margin:2vh 0.5vw;max-width:350px;">';
                        echo '<a href="video.php?id=' . $id . '">';
                        if ($thumbEsc !== '') {
                            echo '<img src="uploads/user-thumbnails/' . $thumbEsc . '" alt="' . $title . '" style="width:350px;height:200px;border-radius:5px;object-fit:cover;" />';
                        } else {
                            echo '<div style="width:350px;height:200px;border-radius:5px;background:#222;display:flex;align-items:center;justify-content:center;color:#aaa;">Geen thumbnail</div>';
                        }
                        echo '</a>';
                        echo '<h3 style="margin:8px 0 4px 0;">' . $title . '</h3>';
                        echo '<p style="margin:0;color:#bbb;font-size:0.9rem;">' . $channel . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>


    </main>
    <footer>

    </footer>

</body>

</html>