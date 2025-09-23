document.addEventListener("DOMContentLoaded", () => {

    const container = document.querySelector(".right_side");


    videos.forEach(video => {

        const videoDiv = document.createElement('div')
        videoDiv.style.display = "flex";
        videoDiv.style.flexDirection = "column";
        videoDiv.style.margin = "2vh 0.5vw";
        container.appendChild(videoDiv)

        const videoImg = document.createElement("img")
        videoImg.src = video.thumbnail || "https://picsum.photos/350/200?random=" + (Math.random() * 1000);
        videoImg.classList = "videoClass";
        videoImg.style.borderRadius = "5px";
        videoDiv.appendChild(videoImg)

        const videoTitle = document.createElement("h2")
        videoTitle.innerText = video.video_title;
        videoDiv.appendChild(videoTitle)

        const videoChannel = document.createElement("p")
        videoChannel.innerText = video.channel_name;
        videoChannel.style.margin = 0;
        videoDiv.appendChild(videoChannel)


    });

});