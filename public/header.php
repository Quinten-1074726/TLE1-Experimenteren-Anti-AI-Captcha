<head>
    <!-- deze shit werkt niet bro ik heb ze allemaal toegevoegd -->
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
        <div class="nav-actions">
        <?php
        // Admin knop links van account/login knop
        if (isset($_SESSION['loggedIn']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo '<a href="admin-account-manager.php" id="admin-dashboard">Admin</a>';
        }
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            echo '<a href="account.php" id="login_button">Account</a>';
        } else {
            echo '<a href="login.php" id="login_button">Login</a>';
        }
        ?>
        </div>
    </nav>
</header>