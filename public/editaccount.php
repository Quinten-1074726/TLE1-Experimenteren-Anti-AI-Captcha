<?php
// 1. connectie met database
require_once 'database/connection.php';

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'tle1';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

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
    $password = mysqli_real_escape_string($db, $_POST['password'] ?? '');
    $id = (int)($_POST['updateId'] ?? 0);

    // Validatie
    if ($username === '') {
        $errorName = 'Vul een naam in';
    }
    if ($email === '') {
        $errorEmail = 'Vul een email in';
    }
    if ($password === '') {
        $errorPassword = 'Vul een wachtwoord in';
    }

    // Alles ingevuld? Dan updaten
    if ($errorName === '' && $errorEmail === '' && $errorPassword === '') {
        $query = "
            UPDATE users 
            SET username='$username', email='$email', password='$password'
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Account bewerken</title>
</head>
<body>
<div class="container px-4">
    <h1 class="title mt-4">Edit account</h1>

    <section class="columns">
        <form class="column is-6" action="" method="post">

            <div class="field">
                <label class="label" for="username">Name</label>
                <div class="control">
                    <input class="input" id="username" type="text" name="username"
                           value="<?= htmlentities($users['username']) ?>"/>
                </div>
                <p class="help is-danger"><?= $errorName ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                    <input class="input" id="email" type="email" name="email"
                           value="<?= htmlentities($users['email']) ?>"/>
                </div>
                <p class="help is-danger"><?= $errorEmail ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                    <input class="input" id="password" type="text" name="password"
                           value="<?= htmlentities($users['password']) ?>"/>
                </div>
                <p class="help is-danger"><?= $errorPassword ?? '' ?></p>
            </div>

            <div class="field">
                <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
            </div>

            <input type="hidden" name="updateId" value="<?= $users['id'] ?>">
        </form>
    </section>

    <a href="account.php?id=<?= $users['id'] ?>">&laquo; Go back to account</a>
</div>
</body>
</html>
