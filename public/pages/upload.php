<?php
    /** @var mysqli $db */
    require_once "../database/connection.php";
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
    <link rel="stylesheet" href="/styling/upload.css">
</head>
<body>
<?php include '../partials/header.php' ?>
<section class="upload-wrap">
    <div class="title-bar">Video uploaden</div>
    <form id="uploadForm" class="upload-card">

    <div class="grid">
      <!-- LINKERKOLOM -->
      <div class="col col-left">
        <label class="field">   
          <span class="label strong">Titel:</span>
          <input type="text" name="title" placeholder="" required>
        </label>

        <label class="field">
          <span class="label strong">Beschrijving:</span>
          <textarea name="description" rows="7" placeholder="" required></textarea>
        </label>

        <div class="field">
          <span class="label strong">Thumbnail:</span>
          <div class="thumb-row">
            <label class="thumb-slot is-drop" id="thumbDrop" tabindex="0">
              <input type="file" id="thumbInput" name="thumbnail" accept="image/*" hidden>
              <span>Klik of sleep</span>
              <img id="thumbPreview" alt="" hidden>
            </label>
            <div class="thumb-slot"></div>
            <div class="thumb-slot"></div>
            <div class="thumb-slot"></div>
          </div>
        </div>

        <label class="field compact">
          <span class="label">Zichtbaarheid</span>
          <select name="visibility">
            <option value="public">Openbaar</option>
            <option value="unlisted">Verborgen</option>
            <option value="private">Privé</option>
          </select>
        </label>
      </div>

      <!-- RECHTERKOLOM -->
      <div class="col col-right">
        <span class="label strong">Upload hier je video</span>
        <label class="video-drop dropzone" id="videoDrop" tabindex="0">
          <input type="file" id="videoInput" name="video" accept="video/mp4,video/webm" hidden required>
          <div class="dz-inner">
            <p>Sleep of klik</p>
            <small>MP4/WebM - max 200MB</small>
          </div>
          <div id="videoInfo" class="file-info" hidden></div>
        </label>
      </div>
    </div>

    <div class="actions">
      <button type ="submit" class="btn-primary">Uploaden</button>
    </div>
    </form>
</section>

<script src="/assets/js/uploadpage.js" defer></script>
