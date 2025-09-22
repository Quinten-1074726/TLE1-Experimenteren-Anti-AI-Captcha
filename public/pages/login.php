<?php
global $query;
$host = "127.0.0.1";
$database = "tle1";
$user = "root";
$password = "";

$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());

// required when working with sessions
session_start();

$login = false;
// Is user logged in?

if (isset($_POST['submit'])) {
    print_r($_POST);
// Get form data

    //beveilig id met SQL-injections
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
        //het resultaat van de query
        $result = mysqli_query($db, $query);

        //aantal toegevoegde logins
        $rows = mysqli_num_rows($result);
        echo $rows;

        //ALS er 1 login is toegevoegd
        if ($rows === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                echo "Login successful";
                $login = true;

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'id' => $user ['id'],
                    'name' => $user ['name'],
                    'email' => $user ['email'],
                ];
                //.. = map uit gaan
                header("Location: ../index.php");
                exit;
            } else {
                echo 'Unknown user';
            }
            //ga terug naar index pagina
            //*hij kan index.php niet vinden? !!!!!!!!!!
            //session starten om user te storen
            //User kan gedisplayed worden op externe pagina

        } else {
            echo "Login failed";
        }
    }


}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Log in</title>
</head>
<body>
<section class="section">
    <div class="container content">
        <h2 class="title">Log in</h2>

        <?php if ($login) { ?>
            <p>Je bent al ingelogd!</p>
            <p><a href="logout.php">Uitloggen</a>
        <?php } else { ?>
            <?php if (isset($email, $password)&& $email != '' && $password != '') { ?>
                <?php //zorg ervoor dat javascript niet uitgevoerd wordt met cross site scripting.?>
                <?= htmlentities($email) ?>
                <?= htmlentities($password) ?>
            <?php } ?>
            <section class="columns">
                <form class="column is-6" action="" method="post">

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="email">Email</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="email" type="text" name="email"
                                           value="<?= $email ?? '' ?>"/>
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['email'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="password">Password</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="password" type="password" name="password"/>
                                    <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>

                                    <?php if (isset($errors['loginFailed'])) { ?>
                                        <div class="notification is-danger">
                                            <button class="delete"></button>
                                            <?= $errors['loginFailed'] ?>
                                        </div>
                                    <?php } ?>

                                </div>
                                <p class="help is-danger">
                                    <?= $errors['password'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal"></div>
                        <div class="field-body">
                            <button class="button is-link is-fullwidth" type="submit" name="submit">Log in With Email
                            </button>
                        </div>
                    </div>

                </form>
            </section>

        <?php } ?>

    </div>
</section>
</body>
</html>


