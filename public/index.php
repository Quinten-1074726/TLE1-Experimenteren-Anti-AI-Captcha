
<?php
require_once 'database/connection.php';

$sql = "SELECT * FROM videos ORDER BY id DESC";
$result = mysqli_query($db, $sql);

$videos = []; // <-- array waar alles in gefetcht word

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $videos[] = $row; 
    }
} else {
    die("Query failed: " . mysqli_error($db));
}

?>

<!-- script zorgt ervoor dat php data omgezet word naar json, wat javascript (in de head) gebruikt) -->
<script>
    // json flags om speciale characters niet code te laten breken
    const videos = <?php echo json_encode($videos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    console.log(videos); 
</script>


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
    <script src="javascript/index.js"></script>
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=SUSE+Mono:ital,wght@0,100..800;1,100..800&display=swap"
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
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </span>
                    </label>
                </div>

                <a href="index.php">Home</a>
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

    </main>
    <footer>

    </footer>

</body>

</html>