// public/javascript/index.js
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".right_side");
  const aiFilterCheckbox = document.getElementById("ai_filter");
  const loadMoreWrap = document.querySelector(".flex_right_side");

  const urlParams = new URLSearchParams(window.location.search);
  const searchTerm = urlParams.get('s') || '';

  const perPage = 9;
  let offset = 0;
  let hasMore = true;
  let currentAiOnly = ''; // '', '1', '0'

  // UI: button
  const loadMoreBtn = document.createElement("button");
  loadMoreBtn.innerText = "Load More";
  loadMoreBtn.addEventListener("click", fetchAndRender);
  loadMoreWrap.appendChild(loadMoreBtn);

  function getAiOnlyValue() {
    // interpretatie: aangevinkt = alleen AI
    return aiFilterCheckbox && aiFilterCheckbox.checked ? '1' : '';
  }

  async function fetchAndRender() {
    if (!hasMore) return;

    const ai_only = currentAiOnly;
    const qs = new URLSearchParams({
      s: searchTerm,
      ai_only,
      sort: 'new',
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
    } catch (err) {
      console.error(err);
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
    // Let op pad: vanaf /public/index.php is dit goed:
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

  // events
  if (aiFilterCheckbox) {
    aiFilterCheckbox.addEventListener("change", resetAndFetch);
  }

  // initial
  currentAiOnly = getAiOnlyValue();
  resetAndFetch();
});
