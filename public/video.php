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
//comments
if (isset($_POST['submit'])) {
    //altijd de variabele erboven zetten, zodat hij geen errors aangeeft.
    $errorName = '';
    $errorComment = '';


    //variabelen aanmaken
    //value in de post is altijd de id van de input
    $name = mysqli_escape_string($db, $_POST['name']);
    $comment = mysqli_escape_string($db, $_POST['comment']);
    //$date = mysqli_escape_string($db, $_POST['date']);

    //validatie bericht
    if ($name === '') {
        $errorName = 'Please put your name!';
    }
    if ($comment === '') {
        $errorComment = 'Leave a comment!';
    }

    if ($name !== '' && $comment !== '') {
        $userId = $_SESSION['user_id'] ?? 1; // 1 = Guest user in database

        $query = "INSERT INTO comments (`comment`, `parent_id`, `created_at`, `updated_at`, `name`, `user_id`)
              VALUES ('$comment', 0, current_timestamp, current_timestamp, '$name', $userId)";

        mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . ' with query: ' . $query);
        //geen resfresh
        header("Location: video.php?id=" . urlencode($videoID));
        exit;
    }



}
$comments = [];
$result = mysqli_query($db, "SELECT * FROM comments");
//echo $query;

while ($row = mysqli_fetch_assoc($result)) {
    // Add the row to the $reviews array
    $comments[] = $row;
}

mysqli_close($db);


?>


<!DOCTYPE html>
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
            <?php
            // Bepaal het juiste pad naar de video
            $filePath = $video['file_path'];
            if ($filePath === null) {
                $filePath = '';
            } elseif (strpos($filePath, 'http') === 0) {
                // URL, leave as is
            } elseif (strpos($filePath, 'user-videos/') === 0) {
                $filePath = 'uploads/' . $filePath;
            } elseif (strpos($filePath, 'uploads/') !== 0) {
                $filePath = 'uploads/user-videos/' . $filePath;
            }
            if ($filePath === '') {
                echo '<p style="color:red;">Video file not found.</p>';
            } else {
            ?>
            <video id="video" width="auto" height="560" controls>
                <source src="<?= htmlspecialchars($filePath) ?>" type="video/mp4">
            </video>
            <?php } ?>
            <h2> <?= htmlspecialchars($video['video_title']) ?></h2>
            <div id="viewsAndDescription">
                <p><?= htmlspecialchars($video['views']) ?> Views</p>
                <p><?= htmlspecialchars($video['video_description']) ?></p>
            </div>
        </div>
        <!---comments--->
        <div class="commentContainer">
        <h1 class="title mt-4">Comments</h1>
        <h2>Laat feedback achter!</h2>

        <section class="comment-layout">

            <!-- Form links -->
            <form action="" method="post" class="comment-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name"
                           value="<?= htmlentities($_POST['name'] ?? '') ?>"/>
                    <p class="error"><?= $errorName ?? '' ?></p>
                </div>

                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment"><?= htmlentities($_POST['comment'] ?? '') ?></textarea>
                    <p class="error"><?= $errorComment ?? '' ?></p>
                </div>

                <button type="submit" name="submit">Leave comment</button>
            </form>

            <!-- Comments rechts -->
            <div class="comment-list">
                <?php foreach ($comments as $comment) { ?>
                    <div class="comment-card">
                        <div class="comment-header">
                            <span class="comment-author"><?= htmlentities($comment['name']) ?></span>
                            <span class="comment-date"><?= htmlentities($comment['created_at']) ?></span>
                        </div>
                        <div class="comment-body">
                            <?= nl2br(htmlentities($comment['comment'])) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- CSS direct in de section -->
            <style>
                .comment-layout {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    gap: 2rem;
                    margin-top: 2rem;
                }

                /* Form links */
                .comment-form {
                    flex: 1;
                    max-width: 40%;
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                }

                .comment-form .form-group {
                    display: flex;
                    flex-direction: column;
                }

                .comment-form label {
                    font-weight: bold;
                    margin-bottom: 0.3rem;
                }

                .comment-form input,
                .comment-form textarea {
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    padding: 0.5rem;
                    font-size: 1rem;
                }

                .comment-form button {
                    background: #0077ff;
                    color: white;
                    border: none;
                    padding: 0.6rem 1rem;
                    border-radius: 6px;
                    cursor: pointer;
                }

                .comment-form button:hover {
                    background: #005fcc;
                }

                .comment-form .error {
                    color: red;
                    font-size: 0.9rem;
                }

                /* Comments rechts */
                .comment-list {
                    flex: 1;
                    max-width: 55%;
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                }

                .comment-card {
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    padding: 1rem;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .comment-header {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 0.5rem;
                    font-size: 0.9rem;
                    color: #555;
                }

                .comment-author {
                    font-weight: bold;
                    color: #333;
                }

                .comment-body {
                    font-size: 1rem;
                    color: #222;
                    line-height: 1.4;
                }
            </style>
        </section>


    </div>
</main>
</body>

</html>

<?php include './partials/mobile-footer.php'; ?>