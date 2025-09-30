<?php
// api/upload.php
session_start();
require_once __DIR__ . '/../database/connection.php';

// Zorg dat de uploads map bestaat
define('VIDEO_UPLOAD_DIR', __DIR__ . '/../uploads/user-videos/');
define('THUMB_UPLOAD_DIR', __DIR__ . '/../uploads/user-thumbnails/');
if (!is_dir(VIDEO_UPLOAD_DIR)) mkdir(VIDEO_UPLOAD_DIR, 0777, true);
if (!is_dir(THUMB_UPLOAD_DIR)) mkdir(THUMB_UPLOAD_DIR, 0777, true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $visibility = $_POST['visibility'] ?? 'public';
    $ai_generated = isset($_POST['ai_generated']) && $_POST['ai_generated'] == '1' ? 1 : 0;
    // Haal user_id uit sessie
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } elseif (isset($_SESSION['loggedInUser']['id'])) {
        $user_id = $_SESSION['loggedInUser']['id'];
    } else {
        $errors[] = 'Je moet ingelogd zijn om te uploaden.';
    // SESSION debug output verwijderd voor gebruikers
        $user_id = null;
    }
    // Haal channel_name uit de database op basis van user_id
    if ($user_id !== null) {
        $stmtUser = $db->prepare('SELECT username FROM users WHERE id = ?');
        $stmtUser->bind_param('i', $user_id);
        $stmtUser->execute();
        $stmtUser->bind_result($channel_name);
        if (!$stmtUser->fetch()) {
            $channel_name = 'onbekend';
        }
        $stmtUser->close();
    } else {
        $channel_name = 'onbekend';
    }
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
        if ($video['size'] > 8 * 1024 * 1024) {
            $errors[] = 'Video is te groot (max 8MB).';
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

    if (empty($errors) && $user_id !== null) {
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

        // In database zetten: sla alleen de bestandsnaam op
        $stmt = $db->prepare('INSERT INTO videos (video_title, video_description, thumbnail, user_id, date, file_path, channel_name, ai_generated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssisssi', $title, $description, $thumbFileName, $user_id, $date, $videoFileName, $channel_name, $ai_generated);
        if ($stmt->execute()) {
            header('Location: ../index.php');
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
