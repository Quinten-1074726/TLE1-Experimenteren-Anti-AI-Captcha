<?php
/** @var mysqli $db */
require_once "./database/connection.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}
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
        action="public/api/upload.php"
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
            <!-- Dummy slots voor de look -->
            <div class="upload-thumb-slot"></div>
            <div class="upload-thumb-slot"></div>
            <div class="upload-thumb-slot"></div>
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
      </div>
      <!-- RECHTERKOLOM -->
      <div class="upload-col upload-col-right">
        <span class="upload-label upload-strong">Upload hier je video</span>
        <label class="upload-video-drop upload-dropzone" id="videoDrop" tabindex="0">
          <input type="file" id="videoInput" name="video" accept="video/mp4,video/webm" hidden required>
          <div class="upload-dz-inner">
            <p>Sleep of klik</p>
            <small>MP4/WebM - max 200MB</small>
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

<script src="/assets/js/uploadpage.js" defer></script>
</body>
</html>
