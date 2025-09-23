document.addEventListener("DOMContentLoaded", () => {

    const container = document.querySelector(".right_side");


    videos.forEach(video => {

        const videoDiv = document.createElement('div')
        videoDiv.style.display = "flex";
        videoDiv.style.flexDirection = "column";
        videoDiv.style.margin = "2vh 0.5vw";
        container.appendChild(videoDiv)

        const videoImg = document.createElement("img")
        videoImg.src = "../public/uploads/user-thumbnails/" + video.thumbnail;
        videoImg.style.width = "350px";
        videoImg.style.height = "200px";
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