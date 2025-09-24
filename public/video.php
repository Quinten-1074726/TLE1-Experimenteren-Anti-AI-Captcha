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

echo $video['file_path']

?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "header.php" ?>
    <main>
        
    </main>
</body>

</html>