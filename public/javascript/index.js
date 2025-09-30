// public/javascript/index.js
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".right_side");
  const aiFilterCheckbox = document.getElementById("ai_filter");
  const loadMoreWrap = document.querySelector(".flex_right_side");
  const searchInput = document.getElementById("site-search");

  const perPage = 9;
  let offset = 0;
  let hasMore = true;
  let currentAiOnly = '';
  let currentQuery = new URLSearchParams(window.location.search).get('s') || '';

  // Abort vorige fetch
  let inFlightController = null;

  // UI: Load more
  const loadMoreBtn = document.createElement("button");
  loadMoreBtn.innerText = "Load More";
  loadMoreBtn.addEventListener("click", () => fetchAndRender(false));
  loadMoreWrap.appendChild(loadMoreBtn);

  // PREVIEW placeholders
  const previewHTML = (n = perPage) =>
    Array.from({ length: n }, () => `
      <div class="vid-card preview_card">
        <div class="thumb"></div>
        <div class="line title"></div>
        <div class="line meta"></div>
      </div>
    `).join('');

  function applyFadeIn() {
    container.classList.remove('fade-in');
    // force reflow zodat animatie herstart
    // eslint-disable-next-line no-unused-expressions
    container.offsetWidth;
    container.classList.add('fade-in');
  }

  function getAiOnlyValue() {
    return aiFilterCheckbox?.checked ? '1' : '';
  }

  function buildCardsHTML(list) {
    return list.map(video => `
      <div class="vid-card">
        <a href="./video.php?id=${video.id}">
          <img class="thumb-img" src="uploads/user-thumbnails/${video.thumbnail || ''}" alt="${video.video_title || 'video thumbnail'}">
        </a>
        <h2>${video.video_title || ''}</h2>
        <p>${video.channel_name || ''}</p>
      </div>
    `).join('');
  }

  async function fetchAndRender(reset = false) {
    if (reset) {
      offset = 0;
      hasMore = true;
      container.innerHTML = previewHTML(6); // <-- preview_cards tonen
      loadMoreBtn.style.display = "none";
    }
    if (!hasMore) return;

    inFlightController?.abort();
    inFlightController = new AbortController();

    const qs = new URLSearchParams({
      s: currentQuery,
      ai_only: currentAiOnly,
      sort: 'new',
      limit: String(perPage),
      offset: String(offset),
    });

    try {
      const res = await fetch(`api/videos.php?${qs.toString()}`, {
        headers: { 'Accept': 'application/json' },
        signal: inFlightController.signal
      });
      if (!res.ok) throw new Error('Netwerkfout');
      const data = await res.json();

      const list = Array.isArray(data.videos) ? data.videos : [];

      if (offset === 0) {
        container.innerHTML = buildCardsHTML(list);
        applyFadeIn();
      } else {
        container.insertAdjacentHTML('beforeend', buildCardsHTML(list));
      }

      offset += list.length;
      if (list.length < perPage) {
        hasMore = false;
        loadMoreBtn.style.display = "none";
      } else {
        loadMoreBtn.style.display = "inline-block";
      }
    } catch (err) {
      if (err.name === 'AbortError') return;
      console.error(err);
      container.innerHTML = '<p style="color:red">Fout bij laden van videos.</p>';
      hasMore = false;
      loadMoreBtn.style.display = "none";
    }
  }

  // 120ms debounce
  let typeTimer;
  function scheduleSearch() {
    clearTimeout(typeTimer);
    typeTimer = setTimeout(() => {
      const url = new URL(window.location);
      if (currentQuery) url.searchParams.set('s', currentQuery);
      else url.searchParams.delete('s');
      window.history.replaceState({}, '', url);
      fetchAndRender(true);
    }, 120);
  }

  // Events
  aiFilterCheckbox?.addEventListener("change", () => {
    currentAiOnly = getAiOnlyValue();
    fetchAndRender(true);
  });

  if (searchInput) {
    searchInput.value = currentQuery;
    searchInput.addEventListener('input', () => {
      currentQuery = searchInput.value.trim();
      scheduleSearch();
    });
  }

  // Start
  currentAiOnly = getAiOnlyValue();
  fetchAndRender(true);
});
