document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('site-search');
  const clearBtn = document.getElementById('clearSearch');
  const bar = input?.closest('.search-bar');
  if (!input || !bar) return;

  const toggleHasValue = () => {
    if (input.value.trim().length > 0) bar.classList.add('has-value');
    else bar.classList.remove('has-value');
  };
  toggleHasValue();

  input.addEventListener('input', toggleHasValue);
  clearBtn?.addEventListener('click', () => {
    input.value = '';
    toggleHasValue();
    input.dispatchEvent(new Event('input'));
  });
});
