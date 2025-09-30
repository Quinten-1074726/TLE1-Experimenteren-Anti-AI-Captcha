
<?php
session_start();
require_once "./database/connection.php";

// Redirect if already logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirectUrl");
    exit;
}

$login = false;
// Is user logged in?

if (isset($_POST['submit'])) {
    // Get form data
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = mysqli_escape_string($db, $_POST['password']);

    // Server-side validation
    $errors = [];
    if ($email == '') {
        $errors['email'] = 'Please fill in your email.';
    }
    if ($password == '') {
        $errors['password'] = 'Please fill in your password.';
    }

    // If data valid
    if (empty($errors)) {
        // SELECT the user from the database, based on the email address.
        $query = "SELECT * FROM users WHERE email= '$email'";
        $result = mysqli_query($db, $query);
        $rows = mysqli_num_rows($result);

        //ALS er 1 login is toegevoegd
        if ($rows === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'id' => $user['id'],
                    'name' => $user['username'],
                    'email' => $user['email'],
                    'is_admin' => $user['is_admin']
                ];
                // Zet ook root-level keys die andere pagina's verwachten
                $_SESSION['is_admin'] = (int)$user['is_admin'];
                $_SESSION['user_id'] = (int)$user['id'];
                // Debug: toon wat er in de sessie staat
                echo '<pre style="background:#222;color:#fff;padding:12px;">';
                echo "<b>Sessie na login:</b>\n";
                print_r($_SESSION);
                echo '</pre>';
                header("Location: index.php");
                exit;
            } else {
                $errors['loginFailed'] = 'Unknown user';
            }
        } else {
            $errors['loginFailed'] = "Login failed";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Log in</title>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/crud.css">
</head>
<body>
<section>
    <form action="" method="post">
        <div class="column" style="width: 65vw; margin: 10vh auto">
            <p class="title" style="font-size: var(--font-header); font-weight: bold">Log in</p>
            <p class="title" style="font-size: var(--font-paragraph)">Log in met je account</p>
            <div class="form-column" style="margin: 10px auto 5px auto">
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
            <div class="form-column" style="margin: 5px auto 10px auto">
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
            <?php if (isset($errors['loginFailed'])) { ?>
                <div class="Danger">
                    <?= $errors['loginFailed'] ?>
                </div>
            <?php } ?>
            <!-- Submit -->
            <button class="link-button" style="margin-bottom: 5vh" type="submit" name="submit">Log in</button>
            <a class="link-button" style="margin-bottom: 5vh; display: inline-block; text-align: center;" href="register.php">Nog geen account? Registreer je hier!</a>
        </div>
    </form>
</section>
</body>
</html>


