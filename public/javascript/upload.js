// Client-side file size check for video upload (max 8MB)
document.addEventListener('DOMContentLoaded', function() {
  // --- Video main preview logic ---
  const videoMainPreview = document.getElementById('videoMainPreview');
  const uploadForm = document.getElementById('uploadForm');
  const videoInput = document.getElementById('videoInput');
  const videoDrop = document.getElementById('videoDrop');
  let errorMsg = null;

    // --- Thumbnail preview logic ---
    const thumbInput = document.getElementById('thumbInput');
    const thumbDrop = document.getElementById('thumbDrop');
    const thumbPreview = document.getElementById('thumbPreview');
    const thumbDropText = thumbDrop.querySelector('span');

    thumbInput.addEventListener('change', function(e) {
      const file = thumbInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          thumbPreview.hidden = true;
          thumbPreview.onload = function() {
            thumbPreview.hidden = false;
            if (thumbDropText) thumbDropText.style.display = 'none';
          };
          thumbPreview.src = ev.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        thumbPreview.src = '';
        thumbPreview.hidden = true;
        if (thumbDropText) thumbDropText.style.display = '';
      }
    });

    // Als thumbnail input al een bestand heeft bij laden (terug navigeren)
    if (thumbInput.files && thumbInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        thumbPreview.hidden = true;
        thumbPreview.onload = function() {
          thumbPreview.hidden = false;
          if (thumbDropText) thumbDropText.style.display = 'none';
        };
        thumbPreview.src = ev.target.result;
      };
      reader.readAsDataURL(thumbInput.files[0]);
    }

  function showError(message) {
    if (!errorMsg) {
      errorMsg = document.createElement('div');
      errorMsg.style.color = 'red';
      errorMsg.style.margin = '16px 0';
      errorMsg.style.fontWeight = 'bold';
      errorMsg.className = 'upload-error-message';
      uploadForm.parentNode.insertBefore(errorMsg, uploadForm);
    }
    errorMsg.textContent = message;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function clearError() {
    if (errorMsg) {
      errorMsg.textContent = '';
    }
  }


  // --- Thumbnail slot selection logic ---
  const previewSlots = [
    document.getElementById('videoPreview1'),
    document.getElementById('videoPreview2'),
    document.getElementById('videoPreview3')
  ];
  let selectedSlotIdx = null;

  // Initially disable the video preview slots
  previewSlots.forEach((img) => {
    if (img) img.parentElement.classList.add('disabled');
  });

  previewSlots.forEach((img, idx) => {
    if (!img) return;
    img.parentElement.addEventListener('click', function() {
      // Deselect all
      previewSlots.forEach((im, i) => {
        if (im) im.parentElement.classList.remove('selected-thumb-slot');
      });
      // Select this
      img.parentElement.classList.add('selected-thumb-slot');
      selectedSlotIdx = idx;
    });
  });

  // --- Video change logic ---
  videoInput.addEventListener('change', function(e) {
    clearError();
    const file = videoInput.files[0];
    // File size check
    if (file && file.size > 8 * 1024 * 1024) {
      showError('Video is te groot (max 8MB). Kies een kleinere video.');
      videoInput.value = '';
      // Clear previews
      for (let i = 1; i <= 3; i++) {
        const img = document.getElementById('videoPreview' + i);
        if (img) { img.style.display = 'none'; img.src = ''; img.parentElement.classList.remove('selected-thumb-slot'); }
      }
      selectedSlotIdx = null;
      return;
    }

    // Enable/disable thumb slots based on video presence
    const hasVideo = file && file.size <= 8 * 1024 * 1024;
    previewSlots.forEach((img) => {
      if (img) {
        if (hasVideo) {
          img.parentElement.classList.remove('disabled');
        } else {
          img.parentElement.classList.add('disabled');
          img.parentElement.classList.remove('selected-thumb-slot');
        }
      }
    });

    // Video frame preview logic
    if (file) {
      // Remove old previews
      for (let i = 1; i <= 3; i++) {
        const img = document.getElementById('videoPreview' + i);
        if (img) { img.style.display = 'none'; img.src = ''; img.parentElement.classList.remove('selected-thumb-slot'); }
      }
      selectedSlotIdx = null;

      // Video preview in rechtervak
      if (videoMainPreview) {
        const video = document.createElement('video');
        video.preload = 'auto';
        video.muted = true;
        video.src = URL.createObjectURL(file);
        video.style.display = 'none';
        document.body.appendChild(video);
        function showMainPreview() {
          // Wacht 50ms zodat het frame goed geladen is
          setTimeout(function() {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            videoMainPreview.src = canvas.toDataURL('image/jpeg');
            videoMainPreview.style.display = 'block';
            canvas.remove();
            document.body.removeChild(video);
            video.removeEventListener('loadeddata', showMainPreview);
          }, 50);
        }
        video.addEventListener('loadeddata', showMainPreview);
      }

      // Frames voor thumbnails
      const video = document.createElement('video');
      video.preload = 'auto';
      video.muted = true;
      video.src = URL.createObjectURL(file);
      video.style.display = 'none';
      document.body.appendChild(video);
      video.addEventListener('loadedmetadata', function() {
        const duration = video.duration;
        if (!duration || duration < 1) {
          document.body.removeChild(video);
          return;
        }
        // Frames op 1/4, 1/2, 3/4 van de video
        const times = [duration * 0.25, duration * 0.5, duration * 0.75];
        let idx = 0;
        function grabNextFrame() {
          if (idx >= times.length) {
            document.body.removeChild(video);
            return;
          }
          video.currentTime = times[idx];
          video.addEventListener('seeked', function handler() {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const img = document.getElementById('videoPreview' + (idx + 1));
            if (img) {
              img.style.display = 'none';
              img.onload = function() {
                img.style.display = 'block';
              };
              img.src = canvas.toDataURL('image/jpeg');
            }
            canvas.remove();
            video.removeEventListener('seeked', handler);
            idx++;
            setTimeout(grabNextFrame, 200);
          });
        }
        grabNextFrame();
      });
    }
  });

  uploadForm.addEventListener('submit', function(e) {
    clearError();
    const file = videoInput.files[0];
    if (file && file.size > 8 * 1024 * 1024) {
      showError('Video is te groot (max 8MB). Kies een kleinere video.');
      e.preventDefault();
      return;
    }
    // Als een slot geselecteerd is, zet die als thumbnail
    if (selectedSlotIdx !== null) {
      const img = previewSlots[selectedSlotIdx];
      if (img && img.src) {
        // DataURL omzetten naar blob en in thumbnail input stoppen
        fetch(img.src)
          .then(res => res.blob())
          .then(blob => {
            const file = new File([blob], 'thumbnail.jpg', { type: 'image/jpeg' });
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('thumbInput').files = dt.files;
            uploadForm.submit();
          });
        e.preventDefault(); // Wacht tot thumbnail is gezet
      }
    }
  });
});
