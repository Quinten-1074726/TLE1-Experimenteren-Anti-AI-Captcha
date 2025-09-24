<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="styling/channel.css">
    <link rel="stylesheet" href="styling/index.css">
    <script src="javascript/channel.js" defer></script>
    <title>Channel page</title>
</head>
<body id="body">

    <?php include "header.php" ?>
<div class="divContainer">

    <div class="left_side">
        <div>
            <a>AI Filter</a>
            <a>Home</a>
            <a href="trending.php">Trending</a>
            <a>Subcriptions</a>
        </div>
        <div>
            <!-- channels here -->
            <a>channel 1</a>
            <a>channel 123</a>

        </div>
    </div>
    <!-- right -->
    <div class="right_side">
        <!-- script -->
    </div>

<div class="emptyContainer">

</div>

<section id="right">
    <div class="rightDiv">
        <div class="banner">
            <img class="imageBanner" src="images/banner.png">
        </div>
        <div class="profile">
            <div style="display: flex; flex-direction: row">
                <div class="profilePicture">
                    <img style="scale: 1.3" src="images/profile.png">
                </div>
                <div class="channelDetails">
                    <div class="channelName">
                        <h2>Channel name</h2>
                    </div>
                </div>
            </div>
                <div class="amounts">
                    <p>
                        subscribercount
                    </p>
                    <p>
                        a/o videos
                    </p>
                </div>
            </div>
        </div>
        <div class="overviewVideos">
            <div class="video1 ">

            </div>
        </div>
    </div>
</section>

</div>
</body>
</html>
