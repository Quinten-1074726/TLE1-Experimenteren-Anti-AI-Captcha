<?php
// api/upload.php
require_once __DIR__ . '/../public/database/connection.php';

// Zorg dat de uploads map bestaat
define('VIDEO_UPLOAD_DIR', __DIR__ . '/../public/uploads/user-videos/');
define('THUMB_UPLOAD_DIR', __DIR__ . '/../public/uploads/user-thumbnails/');
if (!is_dir(VIDEO_UPLOAD_DIR)) mkdir(VIDEO_UPLOAD_DIR, 0777, true);
if (!is_dir(THUMB_UPLOAD_DIR)) mkdir(THUMB_UPLOAD_DIR, 0777, true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $visibility = $_POST['visibility'] ?? 'public';
    $user_id = 1; // Pas aan: haal uit sessie als je login hebt
    $channel_name = 'test'; // Pas aan indien nodig
    $date = date('Y-m-d');

    // --- VIDEO ---
    if (!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Video uploaden mislukt.';
    } else {
        $video = $_FILES['video'];
        $allowedTypes = ['video/mp4', 'video/webm'];
        if (!in_array($video['type'], $allowedTypes)) {
            $errors[] = 'Alleen MP4 of WebM toegestaan.';
        }
        if ($video['size'] > 200 * 1024 * 1024) {
            $errors[] = 'Video is te groot (max 200MB).';
        }
    }

    // --- THUMBNAIL ---
    if (!isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Thumbnail uploaden mislukt.';
    } else {
        $thumb = $_FILES['thumbnail'];
        $allowedThumbTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($thumb['type'], $allowedThumbTypes)) {
            $errors[] = 'Alleen JPG, PNG of WEBP thumbnail toegestaan.';
        }
        if ($thumb['size'] > 5 * 1024 * 1024) {
            $errors[] = 'Thumbnail is te groot (max 5MB).';
        }
    }

    if (empty($errors)) {
        // Video opslaan
        $videoExt = pathinfo($video['name'], PATHINFO_EXTENSION);
        $videoFileName = uniqid('video_', true) . '.' . $videoExt;
        $videoPath = VIDEO_UPLOAD_DIR . $videoFileName;
        move_uploaded_file($video['tmp_name'], $videoPath);

        // Thumbnail opslaan
        $thumbExt = pathinfo($thumb['name'], PATHINFO_EXTENSION);
        $thumbFileName = uniqid('thumb_', true) . '.' . $thumbExt;
        $thumbPath = THUMB_UPLOAD_DIR . $thumbFileName;
        move_uploaded_file($thumb['tmp_name'], $thumbPath);

        // Thumbnail als blob inlezen
        $thumbBlob = file_get_contents($thumbPath);

        // In database zetten
        $stmt = $db->prepare('INSERT INTO videos (video_title, video_description, thumbnail, user_id, date, file_path, channel_name) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssisss', $title, $description, $thumbBlob, $user_id, $date, $videoFileName, $channel_name);
        if ($stmt->execute()) {
            header('Location: /upload.php?success=1');
            exit;
        } else {
            $errors[] = 'Databasefout: ' . $db->error;
        }
    }
}

// Toon errors als die er zijn
if (!empty($errors)) {
    echo '<div style="color:red; padding:16px;">'.implode('<br>', $errors).'</div>';
}
