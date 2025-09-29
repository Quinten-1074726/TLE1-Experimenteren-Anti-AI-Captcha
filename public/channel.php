<?php
global $query;
$host = "127.0.0.1";
$database = "tle1";
$user = "root";
$password = "";

$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());

////
//$id = $_GET['id'];
//
//$query = "SELECT * FROM users WHERE id = $id";
//
//$result = mysqli_query($db, $query);
//$users = mysqli_fetch_assoc($result);
//mysqli_close($db);
// required when working with sessions
session_start();

// Redirect if already logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

} else {
    header("Location: 'index.php'");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styling/channel.css">
    <link rel="stylesheet" href="styling/index.css" >
    <link rel="stylesheet" href="styling/style.css" >
    <script src="javascript/channel.js" defer></script>
    <title>Channel page</title>
</head>
<body id="body">

<?php include "header.php" ?>

<div class="divContainer">
    <div class="left_side">
        <div>
            <div>
                <label id="ai_filter_label">
                    AI Filter
                    <span class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </span>
                </label>
            </div>

            <a href="index.php">Home</a>
            <a href="trending.php">Trending</a>
            <a>Subcriptions</a>
            <a href="channel.php">My channel</a>
            <a href="upload.php" class="btn">Video uploaden</a>
        </div>
        <div>
            <!-- channels here -->
            <a>channel 1</a>
            <a>channel 123</a>

        </div>
    </div>


    <div class="emptyContainer">

    </div>

    <section id="right">
        <div class="rightDiv">
            <div class="banner">
                <img class="imageBanner" src="images/banner.png">
            </div>
            <div class="profile">
                <div style="display: flex; flex-direction: row;">
                    <div class="profilePicture">
                        <img style="scale: 1.3" src="images/profile.png">
                    </div>
                    <div class="channelDetails">
                        <div class="channelName">
                            <h2>Channel name</h2>
                        </div>


                        <div class="amounts">
                            <p>
                                subscribers count || a/o video's
                            </p>

                            <div class="description">

                                    Welcome to my channel!!!, jkcbahjfbahjdashdjbsahdjasbdskdj

                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="lijntje">
            </div>

            <div class="overviewVideos">
                <div class="video1 ">

                </div>
            </div>
        </div>
    </section>

    <!--</div>-->
</body>
</html>
