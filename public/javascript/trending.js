// public/javascript/trending.js
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".right_side");
  const aiFilterCheckbox = document.getElementById("ai_filter");
  const loadMoreWrap = document.querySelector(".flex_right_side");

  const perPage = 9;
  let offset = 0;
  let hasMore = true;
  let currentAiOnly = '';

  const loadMoreBtn = document.createElement("button");
  loadMoreBtn.innerText = "Load More";
  loadMoreBtn.addEventListener("click", fetchAndRender);
  loadMoreWrap.appendChild(loadMoreBtn);

  function getAiOnlyValue() {
    return aiFilterCheckbox && aiFilterCheckbox.checked ? '1' : '';
  }

  async function fetchAndRender() {
    if (!hasMore) return;

    const qs = new URLSearchParams({
      s: '',               // trending: geen zoekterm
      ai_only: currentAiOnly,
      sort: 'views',       // <-- belangrijk
      limit: String(perPage),
      offset: String(offset),
    });

    try {
      const res = await fetch(`api/videos.php?${qs.toString()}`, {
        headers: { 'Accept': 'application/json' }
      });
      if (!res.ok) throw new Error('Netwerkfout');
      const data = await res.json();

      const list = Array.isArray(data.videos) ? data.videos : [];
      list.forEach(renderVideoCard);

      offset += list.length;
      if (list.length < perPage) {
        hasMore = false;
        loadMoreBtn.style.display = "none";
      } else {
        loadMoreBtn.style.display = "inline-block";
      }
    } catch (e) {
      console.error(e);
      container.insertAdjacentHTML('beforeend', '<p style="color:red">Fout bij laden van videos.</p>');
      hasMore = false;
      loadMoreBtn.style.display = "none";
    }
  }

  function resetAndFetch() {
    container.innerHTML = "";
    offset = 0;
    hasMore = true;
    currentAiOnly = getAiOnlyValue();
    loadMoreBtn.style.display = "none";
    fetchAndRender();
  }

  function renderVideoCard(video) {
    const wrap = document.createElement("div");
    wrap.style.display = "flex";
    wrap.style.flexDirection = "column";
    wrap.style.margin = "2vh 0.5vw";
    container.appendChild(wrap);

    const a = document.createElement("a");
    a.href = "./video.php?id=" + video.id;
    wrap.appendChild(a);

    const img = document.createElement("img");
    img.src = "uploads/user-thumbnails/" + (video.thumbnail || "");
    img.alt = video.video_title || "video thumbnail";
    img.style.width = "350px";
    img.style.height = "200px";
    img.style.borderRadius = "5px";
    img.style.objectFit = "cover";
    a.appendChild(img);

    const h2 = document.createElement("h2");
    h2.innerText = video.video_title || '';
    wrap.appendChild(h2);

    const p = document.createElement("p");
    p.innerText = video.channel_name || '';
    wrap.appendChild(p);
  }

  if (aiFilterCheckbox) {
    aiFilterCheckbox.addEventListener("change", resetAndFetch);
  }

  resetAndFetch();
});
