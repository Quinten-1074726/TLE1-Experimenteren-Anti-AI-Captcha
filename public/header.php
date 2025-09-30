<header>
    <nav>
    <h1 class="brand">
        <a href="index.php">
        <i class="fa-solid fa-play" aria-hidden="true"></i>
        <span>StreamHub</span>
        </a>
    </h1>

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
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>

        <button id="searchSubmit" type="submit" class="submit-btn" aria-label="Zoeken">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        </button>
        </div>
    </form>

    <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!empty($_SESSION['loggedIn'])) {
        echo '<a href="account.php" id="login_button"><i class="fa-solid fa-id-card" aria-hidden="true"></i><span>Account</span></a>';
        } else {
        echo '<a href="captcha1.php?redirect=login.php" id="login_button"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i><span>Login/register   </span></a>';
        }
    ?>
    </div>
    </nav>
</header>