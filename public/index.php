<?php

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styling/index.css">
    <script src="javascript/index.js"></script>
</head>






<body>
    <header>
        <nav>
            <h1> StreamHub </h1>
            <form action="/search" method="get" class="search-form">
                <label for="site-search">Search</label>
                <input type="search" id="site-search" name="q" placeholder="Search…" required />
                <button type="submit">🔍</button>
            </form>
            <button><a>login</a></button>
        </nav>
    </header>
    <main>
        <!-- left -->
        <div class="left_side">
            <div>
                <a>AI Filter</a>
                <a>Home</a>
                <a>Trending</a>
                <a>Subcriptions</a>
            </div>
            <div>
                <!-- channels here -->
                <a>channel 1</a>
                <a>channel 123</a>

            </div>
        </div>
        <!-- right -->
        <div class="right_side">

        </div>

    </main>
    <footer>

    </footer>

</body>

</html>