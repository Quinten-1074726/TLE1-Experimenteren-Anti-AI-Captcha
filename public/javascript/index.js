document.addEventListener("DOMContentLoaded", () => {

    const videos = [
        { title: "Video 1", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+1" },
        { title: "Video 2", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+2" },
        { title: "Video 3", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+3" },
        { title: "Video 4", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+4" }
    ];


    const container = document.querySelector(".right_side");

    for (i = 0; i < 3; i++) {
        for (j = 0; j < 3; j++) {
            const videoImg = document.createElement("img")
            videoImg.src = "https://picsum.photos/300/200?random=" + (i*3+j);
            container.appendChild(videoImg)
        }
    }



})