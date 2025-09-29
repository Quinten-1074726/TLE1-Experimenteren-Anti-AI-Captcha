<header>
    <nav>
    <h1><a href="index.php">StreamHub</a></h1>

    <form method="get" class="search-form" id="global-search-form"> 
        <label for="site-search" hidden>Search</label>
        <input id="site-search" type="search" name="s"
                placeholder="Search…" value="<?= htmlspecialchars($_GET['s'] ?? '') ?>">
        <button id="searchSubmit" type="submit">🔍</button>
    </form>

    <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!empty($_SESSION['loggedIn'])) {
        echo '<a href="account.php" id="login_button">Account</a>';
        } else {
        echo '<a href="captcha1.php?redirect=login.php" id="login_button">Login</a>';
        }
    ?>
    </nav>
</header>
