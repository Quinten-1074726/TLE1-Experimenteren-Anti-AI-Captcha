// Video selecteren via click op hele item
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('admin-modal-video-item') || e.target.closest('.admin-modal-video-item')) {
    const item = e.target.classList.contains('admin-modal-video-item') ? e.target : e.target.closest('.admin-modal-video-item');
    const checkbox = item.querySelector('input[type="checkbox"]');
    if (checkbox) {
      checkbox.checked = !checkbox.checked;
      item.classList.toggle('selected', checkbox.checked);
    }
  }
});
// Init geselecteerde items bij openen modal
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.admin-modal-video-item').forEach(function(item) {
    const checkbox = item.querySelector('input[type="checkbox"]');
    item.classList.toggle('selected', checkbox && checkbox.checked);
  });
});
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('userSearchInput');
  const userList = document.getElementById('userList');
  const form = document.getElementById('userSearchForm');

  function fetchUsers(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'admin-account-manager.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Zoek alleen het gebruikerslijst HTML fragment
        const parser = new DOMParser();
        const doc = parser.parseFromString(xhr.responseText, 'text/html');
        const newList = doc.getElementById('userList');
        if (newList) userList.innerHTML = newList.innerHTML;
      }
    };
    xhr.send('search=' + encodeURIComponent(query));
  }

  function updateUser(userId, data) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'admin-account-manager.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        showSavedMessage(userId);
      } else {
        console.error('Update failed');
      }
    };
    let params = 'user_id=' + encodeURIComponent(userId);
    for (const key in data) {
      params += '&' + key + '=' + encodeURIComponent(data[key]);
    }
    xhr.send(params);
  }

  function showSavedMessage(userId) {
    // Zoek het inputveld van de username
    const usernameInput = userList.querySelector('.username-input[data-user-id="' + userId + '"]');
    if (!usernameInput) return;
    let msg = document.createElement('span');
    msg.textContent = 'Opgeslagen!';
    msg.style.color = 'limegreen';
    msg.style.fontSize = '0.9em';
    msg.style.marginLeft = '12px';
    msg.className = 'saved-message';
    // Verwijder oude meldingen
    const oldMsg = usernameInput.parentNode.querySelector('.saved-message');
    if (oldMsg) oldMsg.remove();
    usernameInput.parentNode.appendChild(msg);
    setTimeout(() => {
      msg.remove();
    }, 1200);
  }

  searchInput.addEventListener('input', function() {
    fetchUsers(searchInput.value);
  });

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    fetchUsers(searchInput.value);
  });

  // Event listeners voor auto-save
  userList.addEventListener('keydown', function(e) {
    if (e.target.classList.contains('username-input') && e.key === 'Enter') {
      e.preventDefault();
      const userId = e.target.getAttribute('data-user-id');
      const username = e.target.value.trim();
      // Zoek de admin-checkbox die bij deze gebruiker hoort
      const adminCheckbox = userList.querySelector('.admin-checkbox[data-user-id="' + userId + '"]');
      const isAdmin = adminCheckbox && adminCheckbox.checked ? 1 : 0;
      if (username) {
        updateUser(userId, { username: username, is_admin: isAdmin });
      }
    }
  });

  userList.addEventListener('change', function(e) {
    if (e.target.classList.contains('admin-checkbox')) {
      const userId = e.target.getAttribute('data-user-id');
      const isAdmin = e.target.checked ? 1 : 0;
      updateUser(userId, { is_admin: isAdmin });
    }
  });

  // Initial load
  fetchUsers('');
});
