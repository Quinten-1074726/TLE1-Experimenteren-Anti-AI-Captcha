document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".right_side");
    const aiFilterCheckbox = document.getElementById("ai_filter");
    const loadMoreButtonSide = document.querySelector(".flex_right_side");

    const videosPerPage = 9;
    let currentIndex = 0;
    let currentVideos = [];

    const loadMoreBtn = document.createElement("button");
    loadMoreBtn.innerText = "Load More";
    loadMoreBtn.addEventListener("click", displayMoreVideos);
    loadMoreButtonSide.appendChild(loadMoreBtn);

    async function fetchVideos() {
        // New logic: unchecked = all, checked = only non AI generated
        const nonAiOnly = aiFilterCheckbox && aiFilterCheckbox.checked ? '1' : '0';
        const url = `api/videos.php?non_ai_only=${nonAiOnly}`;
        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();

            currentVideos = Array.isArray(data.videos) ? data.videos : [];
            currentIndex = 0;
            container.innerHTML = "";
            loadMoreBtn.style.display = currentVideos.length > 0 ? "inline-block" : "none";

            if (currentVideos.length === 0) {
                const emptyMsg = document.createElement("p");
                emptyMsg.textContent = nonAiOnly === '1' ? 'Geen niet-AI videos gevonden.' : 'Geen videos gevonden.';
                container.appendChild(emptyMsg);
                return;
            }

            displayMoreVideos();
        } catch (e) {
            console.error(e);
            container.innerHTML = '<p style="color:red">Fout bij laden van videos.</p>';
        }
    }

    function displayMoreVideos() {
        const nextVideos = currentVideos.slice(currentIndex, currentIndex + videosPerPage);
        nextVideos.forEach(renderVideoCard);
        currentIndex += videosPerPage;
        if (currentIndex >= currentVideos.length) {
            loadMoreBtn.style.display = "none";
        }
    }

    function renderVideoCard(video) {
        const videoDiv = document.createElement("div");
        videoDiv.style.display = "flex";
        videoDiv.style.flexDirection = "column";
        videoDiv.style.margin = "2vh 0.5vw";
        container.appendChild(videoDiv);

        const videoLink = document.createElement("a");
        videoLink.href = "./video.php?id=" + video.id;
        videoDiv.appendChild(videoLink);

        const videoImg = document.createElement("img");
        videoImg.src = "../public/uploads/user-thumbnails/" + video.thumbnail;
        videoImg.alt = video.video_title || "video thumbnail";
        videoImg.style.width = "350px";
        videoImg.style.height = "200px";
        videoImg.style.borderRadius = "5px";
        videoLink.appendChild(videoImg);

        const videoTitle = document.createElement("h2");
        videoTitle.innerText = video.video_title;
        videoDiv.appendChild(videoTitle);

        const videoChannel = document.createElement("p");
        videoChannel.innerText = video.channel_name;
        videoDiv.appendChild(videoChannel);
    }

    if (aiFilterCheckbox) {
        aiFilterCheckbox.addEventListener("change", () => {
            fetchVideos(); // refetch videos when checkbox changes
        });
    }

    // Initial fetch (default = all videos)
    fetchVideos();
});
