<head>
    <!-- index.php styling -->
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
        <a href="login.php" id="login_button">login</a>
    </nav>
</header>