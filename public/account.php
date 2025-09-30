<?php
//op pagina laten zien
//username
//pfp
//details voor edit pagina acc

session_start();
require_once 'database/connection.php';

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
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">
    <title>Account</title>
</head>
<body>
<section>
    <div class="column" style="width: 65vw; margin: 10vh auto">
        <p class="title" style="font-size: var(--font-header); font-weight: bold">Account</p>
        <div class="form-column" style="margin: 10px auto 5px auto">
            <div>
                <label class="label">Gebruikersnaam</label>
            </div>
            <div style="background-color: var(--colors-content-dark); padding: 10px 40px; border: 1px #000 solid; border-radius: 10px">
                <p style="font-weight: 600; font-size: var(--font-header3); margin: 0;"><?= htmlspecialchars($users['username']) ?></p>
            </div>
        </div>
        <div class="form-column" style="margin: 5px auto 10px auto">
            <div>
                <label class="label">E-mailadres</label>
            </div>
            <div style="background-color: var(--colors-content-dark); padding: 10px 40px; border: 1px #000 solid; border-radius: 10px">
                <p style="font-weight: 600; font-size: var(--font-header3); margin: 0;"><?= htmlspecialchars($users['email']) ?></p>
            </div>
        </div>
        <a class="button" style="margin-bottom: 2vh; display: inline-block; text-align: center;" href="editaccount.php?id=<?= $users['id'] ?>">Bewerk account</a>
        <a class="button" style="margin-bottom: 2vh; display: inline-block; text-align: center;" href="logout.php">Uitloggen</a>
        <a href="index.php" style="margin-bottom: 5vh; display: inline-block; text-align: center;">&laquo; Ga terug naar homepage</a>
    </div>
</section>
</body>
</html>