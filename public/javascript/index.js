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

  let inFlightController = null;

  const loadMoreBtn = document.createElement("button");
  loadMoreBtn.innerText = "Load More";
  loadMoreBtn.addEventListener("click", () => fetchAndRender(false));
  loadMoreWrap.appendChild(loadMoreBtn);

  const previewHTML = (n = perPage) =>
    Array.from({ length: n }, () => `
      <div class="vid-card preview_card">
        <div class="thumb"></div>
        <div class="line title"></div>
        <div class="line meta"></div>
      </div>
    `).join('');

  const escapeHTML = (s='') => s.replace(/[&<>"']/g, c =>
    ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]||c)
  );

  function applyFadeIn() {
    container.classList.remove('fade-in');
    container.offsetWidth; 
    container.classList.add('fade-in');
  }

  const getAiOnlyValue = () => (aiFilterCheckbox?.checked ? '0' : '');

  const buildCardsHTML = list => list.map(video => `
      <div class="vid-card">
        <a href="./video.php?id=${video.id}">
          <img class="thumb-img" src="uploads/user-thumbnails/${video.thumbnail || ''}" alt="${video.video_title || 'video thumbnail'}">
        </a>
        <h2>${video.video_title || ''}</h2>
        <p>${video.channel_name || ''}</p>
      </div>
    `).join('');

  function showEmptyState() {
    const q = currentQuery.trim();
    container.innerHTML = `
      <div class="empty-state">
        <h3>Geen resultaten gevonden</h3>
        <p>${q ? `Er zijn geen resultaten voor “${escapeHTML(q)}”.` : 'Probeer een andere zoekterm of pas je filters aan.'}</p>
      </div>
    `;
    hasMore = false;
    loadMoreBtn.style.display = "none";
  }

  async function fetchAndRender(reset = false) {
    if (reset) {
      offset = 0;
      hasMore = true;
      container.innerHTML = previewHTML(6);
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

      if (offset === 0 && list.length === 0) {
        showEmptyState();
        return;
      }

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

  currentAiOnly = getAiOnlyValue();
  fetchAndRender(true);
});
