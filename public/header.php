<header>
    <nav>
    <h1><a href="index.php">StreamHub</a></h1>

    <form method="get" class="search-form" id="global-search-form" role="search">
        <label for="site-search" class="sr-only">Zoeken</label>

        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass search-icon" aria-hidden="true"></i>

            <input
            id="site-search"
            type="search"
            name="s"
            placeholder="Zoek naar video's of kanalen…"
            value="<?= htmlspecialchars($_GET['s'] ?? '') ?>"
            autocomplete="off"
            />

            <button type="button" class="clear-btn" id="clearSearch" aria-label="Zoekveld leegmaken">
            <i class="fa-solid fa-xmark"></i>
            </button>

            <button id="searchSubmit" type="submit" class="submit-btn" aria-label="Zoeken">
            <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>


    <div class="nav-links">
    <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['loggedIn']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo '<a href="admin-account-manager.php" id="admin-dashboard" class="nav-link">Admin</a>';
        }
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            $userId = $_SESSION['loggedInUser']['id'];
            echo "<a href='account.php?id=$userId' class='nav-link'>Account</a>";
        } else {
            echo '<a href="captcha1.php?redirect=login.php" id="login_button" class="nav-link">Login</a>';
        }
    ?>
    </div>
    </nav>
</header>
