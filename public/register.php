<?php
$errors = [];
if (!isset($_COOKIE['captcha_pass'])) {
    header('Location: index.php');
    exit;
} else {
    // Invalidate the one-time cookie
}

if (isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "./database/connection.php";
    $userName = $_POST['userName'] ?? '';
    if ($userName === '') {
        $errors['userName'] = "Vul a.u.b. Uw gebruikersnaam in.";
    }
    $email = $_POST['email'] ?? '';
    if ($email === '') {
        $errors['email'] = "Vul a.u.b. Uw e-mail in.";
    }
    $password = $_POST['password'] ?? '';
    if ($password === '') {
        $errors['password'] = "Maak a.u.b. een wachtwoord aan.";
    }
    if (empty($errors)) {
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors['email'] = "Dit e-mailadres is al in gebruik.";
        }
        mysqli_stmt_close($stmt);
    }
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $userName, $email, $hashedPassword);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            setcookie('captcha_pass', '', time() - 3600, '/');
            header('Location: login.php?email=' . urlencode($email));
            exit;
        } else {
            // Foutmelding als de query mislukt
            $errors['query'] = "Er is iets mis gegaan bij het registreren.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>registreren</title>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">
</head>
<body>
<section>
    <form action="" method="post">
        <div class="column" style="width: 65vw; margin: 10vh auto">
            <p class="title" style="font-size: var(--font-header); font-weight: bold">Registreer</p>
            <p class="title" style="font-size: var(--font-paragraph)">Maak een account aan</p>
            <div class="form-column" style="margin: 10px auto 5px auto"> <!-- Gebruikersnaam -->
                <div>
                    <label class="label" for="userName">Gebruikersnaam</label>
                </div>
                <div>
                    <input class="input" id="userName" type="text" name="userName"
                           value="<?= htmlspecialchars($userName ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                </div>
                <p class="Danger">
                    <?= $errors['userName'] ?? '' ?>
                </p>
            </div>
            <div class="form-column" style="margin: 5px auto"> <!-- Email -->
                <div>
                    <label class="label" for="email">E-mailadres</label>
                </div>
                <div>
                    <input class="input" id="email" type="email" name="email"
                           value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                </div>
                <p class="Danger">
                    <?= $errors['email'] ?? '' ?>
                </p>
            </div>
            <div class="form-column" style="margin: 5px auto 10px auto"> <!-- Wachtwoord -->
                <div>
                    <label class="label" for="password">Wachtwoord</label>
                </div>
                <div>
                    <input class="input" id="password" type="password" name="password"/>
                </div>
                <p class="Danger">
                    <?= $errors['password'] ?? '' ?>
                </p>
            </div>
            <!-- Submit -->
            <button class="link-button" style="margin-bottom: 5vh" type="submit" name="submit">Registreer</button>
        </div>
    </form>
</section>
</body>
</html>

<?php include './partials/mobile-footer.php'; ?>