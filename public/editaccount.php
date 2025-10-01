<?php
// 1. connectie met database
require_once 'database/connection.php';

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'tle1-2';

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
    $errorProfilePicture = '';
    $errorBio = '';

    // Escapen
    $username = mysqli_real_escape_string($db, $_POST['username'] ?? '');
    $email = mysqli_real_escape_string($db, $_POST['email'] ?? '');
    $password = mysqli_real_escape_string($db, $_POST['password'] ?? '');
    $profile_picture = mysqli_real_escape_string($db, $_POST["profile_selector"]);
    $bio = mysqli_real_escape_string($db, $_POST['bio'] ?? '');
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
    if ($profile_picture === '') {
        $errorProfilePicture = 'Upload een profiel foto';
    }
    if ($bio === '') {
        $errorBio = 'Vul een bio in';
    }


    // Alles ingevuld? Dan updaten
    if ($errorName !== '' && $errorEmail !== '' && $errorPassword !== '' && $bio !== '')
    {
        $query = "
            UPDATE users 
            SET username='$username', email='$email', password='$password', profile_picture='$profile_picture', bio='$bio'
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
    $users['profile_picture'] = $profile_picture;
    $users['bio'] = $bio;


}

mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Log in</title>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">
    <link rel="stylesheet" href="styling/editaccount.css">
    <script src="javascript/editaccount.js" defer></script>
</head>
<body>
<?php include 'header.php' ?>
<section>
    <form action="" method="post">
        <div class="column" style="width: 65vw; margin: 10vh auto">
            <p class="title" style="font-size: var(--font-header); font-weight: bold">Edit</p>
            <div class="form-column" style="margin: 10px auto 5px auto">
                <div>
                    <label class="label" for="username">Naam</label>
                </div>
                <div>
                    <input class="input" id="username" type="text" name="username"
                           value="<?= htmlentities($users['username']) ?>"/>

                </div>
                <p class="Danger">
                    <?= $errorName ?? '' ?>
                </p>
            </div>

            <div class="form-column" style="margin: 10px auto 5px auto">
                <div>
                    <label class="label" for="email">E-mailadres</label>
                </div>
                <div>
                    <input class="input" id="email" type="email" name="email"
                           value="<?= htmlentities($users['email']) ?>"/>
                </div>
                <p class="Danger">
                    <?= $errorEmail ?? '' ?>
                </p>
            </div>
            <div class="form-column" style="margin: 5px auto 10px auto">
                <div>
                    <label class="label" for="password">Wachtwoord</label>
                </div>
                <div>
                    <input class="input" id="password" type="text" name="password"
                           value="<?= htmlentities($users['password']) ?>"/>
                </div>
                <p class="Danger">
                    <?= $errorPassword ?? '' ?>
                </p>
            </div>

            <div class="form-column" style="margin: 10px auto 5px auto">
                <div>
                    <label class="label" for="bio">Bio</label>
                </div>
                <div>
                    <input class="input" id="bio" type="text" name="bio"
                           value="<?= htmlentities($users['bio']) ?>"/>
                </div>
                <p class="Danger">
                    <?= $errorBio ?? '' ?>
                </p>
            </div>

            <div class="form-column" style="margin: 5px auto 10px auto">
                <div>

                    <img class="profilePicture" alt="pp" src="images/profile-icon.jpg" id="profile_picture">
                    <!--                    <label class="profile-label" for="input_file">profiel foto veranderen</label>-->

                </div>
                <div>
                    <!--                    <input class="input" id="input_file" type="file" name="profile" accept="image/jpeg, image/png, image/jpg"-->
                    <!--                           value="-->
                    <?php //= htmlentities($users['profile_picture']) ?><!--"/>-->

                    <label for="profile_selector">kies een profiel foto</label>

                    <select class="profile-selector" name="profile_selector" style="color: #12161b">

                        <option id="cake" value="cake">Cake</option>
                        <option id="donut" value="donut">Donut</option>

                    </select>
                </div>
                <p class="Danger">
                    <?= $errorProfilePicture ?? '' ?>
                </p>
            </div>
            <?php if (isset($errors['loginFailed'])) { ?>
                <div class="Danger">
                    <?= $errors['loginFailed'] ?>
                </div>
            <?php } ?>
            <!-- Save -->

            <div class="field">
                <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
            </div>

            <input type="hidden" name="updateId" value="<?= $users['id'] ?>">
        </div>
    </form>
</section>
<?php include('footer.php') ?>
</body>
</html>
