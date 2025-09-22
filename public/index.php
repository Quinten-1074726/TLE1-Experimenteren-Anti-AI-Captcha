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
</head>


<script>

    const videos = [
        { title: "Video 1", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+1" },
        { title: "Video 2", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+2" },
        { title: "Video 3", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+3" },
        { title: "Video 4", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+4" }
    ];


    const container = document.querySelector(".right_side");

    for (let i = 0; i < videos.length; i++) {
        // Create a div for each video
        const videoDiv = document.createElement("div");
        videoDiv.classList.add("video-placeholder"); // Add a class for styling

        // Fill it with an image and title
        videoDiv.innerHTML = `
        <img src="${videos[i].thumbnail}" alt="${videos[i].title}">
        <h3>${videos[i].title}</h3>
    `;

        // Append it to the container
        container.appendChild(videoDiv);

</script>



<body>
    <header>
        <nav>
            <h1> StreamHub </h1>
            <form action="/search" method="get" class="search-form">
                <label for="site-search">Search</label>
                <input type="search" id="site-search" name="q" placeholder="Search…" required />
                <button type="submit">🔍</button>
            </form>
            <a>login</a>
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