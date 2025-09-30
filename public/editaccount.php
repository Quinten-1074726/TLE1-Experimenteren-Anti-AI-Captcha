<?php
session_start();

if (!isset($_COOKIE['captcha_pass'])) {
    header('Location: index.php');
    exit;
} else {
    // Invalidate the one-time cookie
    setcookie('captcha_pass', '', time() - 3600, '/');
}

// 1. connectie met database
require_once 'database/connection.php';


// 2. Haal ID op
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// 3. Haal bestaande data uit DB
$query = "SELECT * FROM users WHERE id = " . (int)$id;
$result = mysqli_query($db, $query);
$users = mysqli_fetch_assoc($result);

if (!$users) {
    header('Location: index.php');
    exit;
}

// 4. Als formulier verstuurd is
if (isset($_POST['submit'])) {
    $errorName = '';
    $errorEmail = '';
    $errorPassword = '';

    // Escapen
    $username = mysqli_real_escape_string($db, $_POST['username'] ?? '');
    $email = mysqli_real_escape_string($db, $_POST['email'] ?? '');
    $id = (int)($_POST['updateId'] ?? 0);

    // Validatie
    if ($username === '') {
        $errorName = 'Vul een naam in';
    }
    if ($email === '') {
        $errorEmail = 'Vul een email in';
    }

    // Alles ingevuld? Dan updaten
    if ($errorName === '' && $errorEmail === '' && $errorPassword === '') {
        $query = "
            UPDATE users 
            SET username='$username', email='$email'
            WHERE id = $id";
        mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));

        // Klaar → terug naar overzicht
        header("Location: account.php?id=$id");
        exit;
    }

    // Zet waarden terug in $users zodat formulier opnieuw ingevuld blijft
    $users['username'] = $username;
    $users['email'] = $email;
    $users['password'] = $password;
}

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">
    <title>Account bewerken</title>
</head>
<body>
<section>
    <form action="" method="post">
        <div class="column" style="width: 65vw; margin: 10vh auto">
            <p class="title" style="font-size: var(--font-header); font-weight: bold">Edit account</p>
            <p class="title" style="font-size: var(--font-paragraph)">Bewerk je accountgegevens</p>
            <div class="form-column" style="margin: 10px auto 5px auto">
                <div>
                    <label class="label" for="username">Name</label>
                </div>
                <div>
                    <input class="input" id="username" type="text" name="username"
                           value="<?= htmlentities($users['username']) ?>"/>
                </div>
                <p class="Danger">
                    <?= $errorName ?? '' ?>
                </p>
            </div>
            <div class="form-column" style="margin: 5px auto 10px auto">
                <div>
                    <label class="label" for="email">Email</label>
                </div>
                <div>
                    <input class="input" id="email" type="email" name="email"
                           value="<?= htmlentities($users['email']) ?>"/>
                </div>
                <p class="Danger">
                    <?= $errorEmail ?? '' ?>
                </p>
            </div>
            <!-- Submit -->
            <button class="link-button" style="margin-bottom: 5vh" type="submit" name="submit">Save</button>
            <a href="account.php?id=<?= $users['id'] ?>" style="margin-bottom: 5vh; display: inline-block; text-align: center;">&laquo; Go back to account</a>
            <input type="hidden" name="updateId" value="<?= $users['id'] ?>">
        </div>
    </form>
</section>
</body>
</html>
