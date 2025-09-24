document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".right_side");

    const videosPerPage = 9; // 9 videos per keer
    let currentIndex = 0;

    function displayVideos() {
        const nextVideos = videos.slice(currentIndex, currentIndex + videosPerPage);

        nextVideos.forEach(video => {
            const videoDiv = document.createElement('div')
            videoDiv.style.display = "flex";
            videoDiv.style.flexDirection = "column";
            videoDiv.style.margin = "2vh 0.5vw";
            container.appendChild(videoDiv)

            const videoImgContainer = document.createElement("a")
            videoImgContainer.href = "./video.php?id=" + video.id;
            videoDiv.appendChild(videoImgContainer)

            const videoImg = document.createElement("img")
            videoImg.src = "../public/uploads/user-thumbnails/" + video.thumbnail;
            videoImg.style.width = "350px";
            videoImg.style.height = "200px";
            videoImg.classList = "videoClass";
            videoImg.style.borderRadius = "5px";
            videoImgContainer.appendChild(videoImg)

            const videoTitle = document.createElement("h2")
            videoTitle.innerText = video.video_title;
            videoDiv.appendChild(videoTitle)

            const videoChannel = document.createElement("p")
            videoChannel.innerText = video.channel_name;
            videoChannel.style.margin = 0;
            videoDiv.appendChild(videoChannel)
        });

        currentIndex += videosPerPage;

        // button weghalen als alles er is
        if (currentIndex >= videos.length) {
            loadMoreBtn.style.display = "none";
        }
    }

    const loadMoreButtonSide = document.querySelector(".flex_right_side")
    const loadMoreBtn = document.createElement("button");
    loadMoreBtn.innerText = "Load More";
    loadMoreBtn.addEventListener("click", displayVideos);
    loadMoreButtonSide.appendChild(loadMoreBtn);

    displayVideos();
});
