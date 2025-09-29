<?php
//op pagina laten zien
//username
//pfp
//details voor edit pagina acc

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'tle1-2';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['loggedInUser']['id'];

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id= $id";

$result = mysqli_query($db, $query);
$users = mysqli_fetch_assoc($result);
mysqli_close($db);
?>


<!doctype html>
<html lang="en">
<head>
    <title>Log in</title>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">

</head>
<body>
<?php include 'header.php' ?>
<section>

    <form action="" method="post">
        <div class="column" style="width: 65vw; margin: 10vh auto">
            <p class="title" style="font-size: var(--font-header); font-weight: bold">Account</p>

            <div class="form-column" style="margin: 10px auto 5px auto">


                <p>Gebruikernaam: <?= $users['username'] ?></p>
                <p>E-mail: <?= $users['email'] ?></p>
                <p>Profiel foto: <img alt="#" src="<?= $users['profile_picture'] ?>"></p>

            </div>
            <a href="editaccount.php?id=<?= $users['id'] ?>">Edit</a>


            <a href="index.php?id=<?= $users['id'] ?>">&laquo; Go back to homepage</a>
        </div>
    </form>
</section>
<?php include('footer.php') ?>
</body>
</html>

