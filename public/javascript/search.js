// public/javascript/search.js
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('global-search-form');
  const input = document.getElementById('site-search');
  if (!form || !input) return;

  let t;
  input.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(() => {
      form.requestSubmit(); 
    }, 300);
  });
});
