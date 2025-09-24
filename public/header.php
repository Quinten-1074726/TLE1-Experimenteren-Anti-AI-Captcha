<head>
    <!-- index.php styling -->
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="styling/index.css">
    <link rel="stylesheet" href="styling/header.css">
</head>

<header>
    <nav>
        <h1> <a href="index.php"> StreamHub </a></h1>
        <form action="/search" method="post" class="search-form">
            <label for="site-search" hidden>Search</label>
            <input id="searchVideo" type="search" id="site-search" name="q" placeholder="Search…" required />
            <button id="searchSubmit" type="submit">🔍</button>
        </form>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            echo '<a href="account.php" id="login_button">Account</a>';
        } else {
            echo '<a href="login.php" id="login_button">Login</a>';
        }
        ?>
    </nav>
</header>