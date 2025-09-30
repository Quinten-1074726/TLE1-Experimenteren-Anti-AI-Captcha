<?php
/** @var mysqli $db */
if (!isset($_COOKIE['captcha_pass'])) {
    header('Location: index.php');
    exit;
} else {
    // Invalidate the one-time cookie
    setcookie('captcha_pass', '', time() - 3600, '/');
}

session_start();
require_once "./database/connection.php";
$errors = [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaden</title>

    <?php include "defaultsettings.php"; ?>

    <link rel="stylesheet" href="styling/upload.css?v=2">
</head>
<body class= "upload-page">
<?php include "header.php"; ?>

<section class="upload-wrap">
  <div class="upload-title">Video uploaden</div>

  <form id="uploadForm"
        class="upload-card"
        action="./api/upload.php"
        method="post"
        enctype="multipart/form-data">
    <div class="upload-grid">
      <!-- LINKERKOLOM -->
      <div class="upload-col upload-col-left">
        <div class="upload-field">
          <span class="upload-label upload-strong">Titel:</span>
          <input type="text" name="title" required>
        </div>
        <div class="upload-field">
          <span class="upload-label upload-strong">Beschrijving:</span>
          <textarea name="description" rows="7" required></textarea>
        </div>
        <div class="upload-field">
          <span class="upload-label upload-strong">Thumbnail:</span>
          <div class="upload-thumb-row">
            <!-- Echte dropzone als 1e slot -->
            <label class="upload-thumb-slot is-drop" id="thumbDrop" tabindex="0">
              <input type="file" id="thumbInput" name="thumbnail" accept="image/*" hidden>
              <span>Klik of sleep</span>
              <img id="thumbPreview" alt="" hidden>
            </label>
            <!-- Dummy slots voor video previews -->
            <div class="upload-thumb-slot"><img id="videoPreview1" class="video-preview-thumb" alt="Preview 1" style="width:100%;height:auto;display:none;"></div>
            <div class="upload-thumb-slot"><img id="videoPreview2" class="video-preview-thumb" alt="Preview 2" style="width:100%;height:auto;display:none;"></div>
            <div class="upload-thumb-slot"><img id="videoPreview3" class="video-preview-thumb" alt="Preview 3" style="width:100%;height:auto;display:none;"></div>
          </div>
        </div>
        <div class="upload-field">
          <span class="upload-label">Zichtbaarheid</span>
          <select name="visibility">
            <option value="public">Openbaar</option>
            <option value="unlisted">Verborgen</option>
            <option value="private">Privé</option>
          </select>
        </div>
        <div class="upload-field">
          <label class="upload-label" style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="ai_generated" value="1" style="width:18px;height:18px;">
            <span>AI-gegenereerde video?</span>
          </label>
        </div>
      </div>
      <!-- RECHTERKOLOM -->
      <div class="upload-col upload-col-right">
        <span class="upload-label upload-strong">Upload hier je video</span>
        <label class="upload-video-drop upload-dropzone" id="videoDrop" tabindex="0">
          <input type="file" id="videoInput" name="video" accept="video/mp4,video/webm" hidden required>
          <img id="videoMainPreview" alt="Video preview" style="display:none;max-width:100%;max-height:320px;border-radius:12px;margin-bottom:12px;object-fit:cover;" />
          <div class="upload-dz-inner">
            <p>Sleep of klik</p>
            <small>MP4/WebM - max 8MB</small>
          </div>
          <div id="videoInfo" class="upload-file-info" hidden></div>
        </label>
      </div>
    </div>
    <div class="upload-actions">
      <button type="submit" class="upload-btn-primary">Uploaden</button>
    </div>
  </form>
</section>

</section>

<script src="javascript/upload.js" defer></script>
</body>
</html>
