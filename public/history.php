<?php
// 6 voorbeeldvideo's met thumbnails
$videos = [
    ['title' => 'Video 1', 'thumbnail' => 'https://images.unsplash.com/photo-1514516877083-76c3c8c3f0d3?w=320&h=180&fit=crop'],
    ['title' => 'Video 2', 'thumbnail' => 'https://images.unsplash.com/photo-1502767089025-6572583495f3?w=320&h=180&fit=crop'],
    ['title' => 'Video 3', 'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=320&h=180&fit=crop'],
    ['title' => 'Video 4', 'thumbnail' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=320&h=180&fit=crop'],
    ['title' => 'Video 5', 'thumbnail' => 'https://images.unsplash.com/photo-1523475496153-3d6cc1e9f907?w=320&h=180&fit=crop'],
    ['title' => 'Video 6', 'thumbnail' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=320&h=180&fit=crop'],
];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Video History</title>
    <?php include "defaultsettings.php" ?>
    <!-- page-specific CSS -->
    <link rel="stylesheet" href="styling/channel.css">
    <link rel="stylesheet" href="styling/crud.css">
    <link rel="stylesheet" href="styling/index.css">

    <style>
        /* Extra styling voor de video thumbnails grid */
        .rightDiv {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding-top: 20px;

            /* Zorg dat de grid naar rechts wordt uitgelijnd */
            justify-content: end; /* schuift de hele grid naar rechts */
            padding-right: 40px; /* optioneel: afstand tot de rechterkant */
        }


        .video-card {
            background-color: #414141;
            border-radius: 8px;
            overflow: hidden;
            width: 200px;
            text-align: center;
            transition: transform 0.2s;
        }

        .video-card:hover {
            transform: scale(1.05);
        }

        .video-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .video-card p {
            margin: 5px 0;
            font-size: 0.9em;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <h1>History</h1>
        <div class="search-form">
            <form>
                <input type="text" placeholder="Zoek video..." id="searchVideo">
                <button type="submit" id="searchSubmit">🔍</button>
            </form>
        </div>
        <a href="#" id="login_button">Login</a>
    </nav>
</header>

<main class="divContainer">
    <!-- Links sidepanel -->
    <div class="leftDiv">
        <h2>Menu</h2>
        <div>Home</div>
        <div>History</div>
        <div>Subscriptions</div>
    </div>

    <!-- Rechts: Video thumbnails grid -->
    <div class="rightDiv">
        <?php foreach ($videos as $video): ?>
            <div class="video-card">
                <img src="<?= $video['thumbnail'] ?>" alt="<?= htmlspecialchars($video['title']) ?>">
                <p><?= htmlspecialchars($video['title']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>

</body>
</html>
