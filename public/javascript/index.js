document.addEventListener("DOMContentLoaded", () => {

    const videos = [
        { title: "Video 1", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+1" },
        { title: "Video 2", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+2" },
        { title: "Video 3", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+3" },
        { title: "Video 4", thumbnail: "https://via.placeholder.com/200x120.png?text=Video+4" }
    ];


    const container = document.querySelector(".right_side");

    for (let i = 0; i < 20; i++) {
        for (let j = 0; j < 3; j++) {
            //create divs for every img + title
            const videoDiv = document.createElement('div')
            videoDiv.style.display = "flex";
            videoDiv.style.flexDirection = "column";
            videoDiv.style.margin = "2vh 0.5vw";
            container.appendChild(videoDiv)



            //create img (placeholder) videos
            const videoImg = document.createElement("img")
            videoImg.src = "https://picsum.photos/350/200?random=" + (i * 3 + j);
            videoImg.classList = "videoClass";
            videoImg.style.borderRadius = "5px";
            videoDiv.appendChild(videoImg)


            //make title
            const videoTitle = document.createElement("h2")
            videoTitle.innerText = "title a";
            videoDiv.appendChild(videoTitle)

            const videoChannel = document.createElement("p")
            videoChannel.innerText = "channel name";
            videoChannel.style.margin = 0;
            videoDiv.appendChild(videoChannel)
        }
    }



})