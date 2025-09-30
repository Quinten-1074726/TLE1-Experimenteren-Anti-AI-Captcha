// public/javascript/search.js
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('global-search-form');
  const input = document.getElementById('site-search');
  const clearBtn = document.getElementById('clearSearch');
  const bar = input?.closest('.search-bar');
  if (!form || !input || !bar) return;

  const toggleHasValue = () => {
    if (input.value.trim().length > 0) bar.classList.add('has-value');
    else bar.classList.remove('has-value');
  };
  toggleHasValue();

  let t;
  input.addEventListener('input', () => {
    toggleHasValue();
    clearTimeout(t);
    t = setTimeout(() => form.requestSubmit(), 300); 
  });

  clearBtn?.addEventListener('click', () => {
    input.value = '';
    toggleHasValue();
    form.requestSubmit(); 
  });
});
