// Client-side file size check for video upload (max 8MB)
document.addEventListener('DOMContentLoaded', function() {
  const uploadForm = document.getElementById('uploadForm');
  const videoInput = document.getElementById('videoInput');
  const videoDrop = document.getElementById('videoDrop');
  let errorMsg = null;

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

  previewSlots.forEach((img, idx) => {
    if (!img) return;
    img.parentElement.style.cursor = 'pointer';
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

    // Video frame preview logic
    if (file) {
      // Remove old previews
      for (let i = 1; i <= 3; i++) {
        const img = document.getElementById('videoPreview' + i);
        if (img) { img.style.display = 'none'; img.src = ''; img.parentElement.classList.remove('selected-thumb-slot'); }
      }
      selectedSlotIdx = null;

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
            // Canvas maken
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const img = document.getElementById('videoPreview' + (idx + 1));
            if (img) {
              img.src = canvas.toDataURL('image/jpeg');
              img.style.display = 'block';
            }
            canvas.remove();
            video.removeEventListener('seeked', handler);
            idx++;
            // Pak pas het volgende frame als deze klaar is
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
