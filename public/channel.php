<?php
/** @var mysqli $db */
global $query;
require_once 'database/connection.php';

session_start();

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($db, $query);


$users = mysqli_fetch_assoc($result);

// Redirect if already logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

} else {
    header("Location: index.php");
    exit;
}
//delete
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $users = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$users) {
        // User not found, redirect to index
        header("Location: index.php");
        exit;
    }
}print_r($result); $query;
//global
//
//
//
//$id = $_SESSION['loggedInUser']['id'];
//
//$id = $_GET['id'];
//
//$query = "SELECT * FROM users WHERE id= $id";
//
//$result = mysqli_query($db, $query);
//$users = mysqli_fetch_assoc($result);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/channel.css">
    <link rel="stylesheet" href="styling/index.css" >
    <link rel="stylesheet" href="styling/style.css" >
    <script src="javascript/channel.js" defer></script>
    <title>Channel page</title>
</head>
<body id="body">

<?php include "header.php" ?>

<div class="divContainer">
    <?php $active='home'; $showAiFilter=true; include './partials/sidebar.php'; ?>


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
                        <img style="scale: 1.3" src="images/<?=$users['profile_picture']?>.png">
                    </div>
                    <div class="channelDetails">
                        <div class="channelName">
                            <h2><?= $users['username'] ?></h2>
                        </div>


                        <div class="amounts">
                            <p>
                                <?= $users['email'] ?> subscribers count || a/o video's
                            </p>

                            <div class="description">

                                <?= $users['bio'] ?>

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


</body>
</html>

<?php $active='channel'; include './partials/mobile-footer.php'; ?>
