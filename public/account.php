<?php
//op pagina laten zien
//username
//pfp
//details voor edit pagina acc

require_once "./database/connection.php";

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id= $id";

$result = mysqli_query($db, $query);
$users = mysqli_fetch_assoc($result);
mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Account</h1>
<h2><?= $users['username'] ?></h2>
<h2><?= $users['email'] ?></h2>
</body>
</html>