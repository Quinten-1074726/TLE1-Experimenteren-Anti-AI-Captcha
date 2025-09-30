<?php
/** @var $db */
require_once "admin-auth.php";
require_once('database/connection.php');

$users = null;
$error_message = null;
$success_message = null;
$limit = 20; // Aantal resultaten per pagina
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

// Profiel aanpassen
if (isset($_POST['update_profile'])) {
    $user_id = intval($_POST['user_id']);
    $username = trim($_POST['username']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $profile_picture = $_FILES['profile_picture']['name'] ?? '';
    if ($profile_picture && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $fileName = uniqid('profile_', true) . '.' . $ext;
        $uploadPath = 'uploads/' . $fileName;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath);
        $profile_picture = $uploadPath;
        $query = "UPDATE users SET username=?, is_admin=?, profile_picture=? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sisi", $username, $is_admin, $profile_picture, $user_id);
    } else {
        $query = "UPDATE users SET username=?, is_admin=? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sii", $username, $is_admin, $user_id);
    }
    if ($stmt->execute()) {
        $success_message = "Profiel succesvol aangepast.";
        // Sessie direct updaten als je jezelf admin maakt of ont-adminned
        if (isset($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']['id'] == $user_id) {
            $_SESSION['is_admin'] = $is_admin;
        }
    } else {
        $error_message = "Profiel aanpassen mislukt.";
    }
    $stmt->close();
}

// AJAX updates voor username en is_admin
if (isset($_POST['user_id']) && !isset($_POST['update_profile'])) {
    $user_id = intval($_POST['user_id']);
    $updates = [];
    $types = '';
    $params = [];
    if (isset($_POST['username'])) {
        $updates[] = "username = ?";
        $types .= 's';
        $params[] = trim($_POST['username']);
    }
    if (isset($_POST['is_admin'])) {
        $updates[] = "is_admin = ?";
        $types .= 'i';
        $params[] = intval($_POST['is_admin']);
    }
    if (!empty($updates)) {
        $query = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
        $types .= 'i';
        $params[] = $user_id;
        $stmt = $db->prepare($query);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            // Sessie updaten als nodig
            if (isset($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']['id'] == $user_id && isset($_POST['is_admin'])) {
                $_SESSION['is_admin'] = intval($_POST['is_admin']);
            }
        }
        $stmt->close();
    }
}

// Video verwijderen
if (isset($_POST['delete_video'])) {
    // Video verwijderen (meerdere tegelijk)
    if (isset($_POST['delete_selected_videos']) && isset($_POST['video_ids'])) {
        $videoIds = $_POST['video_ids'];
        $deleted = 0;
        foreach ($videoIds as $vid) {
            $vid = intval($vid);
            $delete_query = "DELETE FROM videos WHERE id = ?";
            $stmt = $db->prepare($delete_query);
            $stmt->bind_param("i", $vid);
            if ($stmt->execute()) {
                $deleted++;
            }
            $stmt->close();
        }
        $success_message = $deleted . " video's succesvol verwijderd.";
    }
}

// AJAX update voor ai_generated van video
if (isset($_POST['video_id']) && isset($_POST['ai_generated'])) {
    $video_id = intval($_POST['video_id']);
    $ai_generated = intval($_POST['ai_generated']);
    $stmt = mysqli_prepare($db, "UPDATE videos SET ai_generated = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $ai_generated, $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // Geen output nodig, AJAX
}

// Gebruikers zoeken (dynamisch op username of email)
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
if ($search !== '') {
    $query = "SELECT * FROM users WHERE username LIKE ? OR email LIKE ? LIMIT ? OFFSET ?";
    $searchParam = "%$search%";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
} else {
    $query = "SELECT * FROM users LIMIT ? OFFSET ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}
?>


<!doctype html>
<html lang="nl">
<head>
    <script>
    function openVideosModal(userId) {
        var modal = document.getElementById('modal-' + userId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }
    function closeVideosModal(userId) {
        var modal = document.getElementById('modal-' + userId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    function confirmDeleteVideos(form) {
        var checked = form.querySelectorAll('input[type=checkbox]:checked').length;
        if (checked === 0) {
            alert('Selecteer minimaal één video om te verwijderen.');
            return false;
        }
        return confirm('Weet je zeker dat je de geselecteerde video\'s wilt verwijderen?');
    }
    // Sluit modal bij klik op overlay
    document.addEventListener('click', function(e) {
        var overlays = document.querySelectorAll('.admin-modal-overlay');
        overlays.forEach(function(overlay) {
            if (overlay.style.display === 'flex' && e.target === overlay) {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    });
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gebruikers</title>
    <?php include "defaultsettings.php" ?>
    <link rel="stylesheet" href="styling/admin-account-dashboard.css">
    <script src="javascript/admin-account-manager.js" defer></script>
</head>
<body>
<?php include('header.php') ?>
<main>
    <section class="search-bar">
        <form id="userSearchForm" action="" method="post" autocomplete="off">
            <input class="account-searchbar" type="text" id="userSearchInput" name="search" placeholder="Zoek op gebruikersnaam of e-mail..." style="width:320px;">
            <button type="submit">Zoeken</button>
        </form>
    </section>
    <section class="dashboard-section">
        <h2>Gebruikers</h2>
        <div class="text-content" id="userList">
            <?php if ($success_message): ?>
                <p style="color: green;"><?= $success_message ?></p>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <p style="color: #f4f4f4;"><?= $error_message ?></p>
            <?php endif; ?>
            <?php if ($users): ?>
                <h3>Gegevens gevonden:</h3>
                <ul>
                    <?php foreach ($users as $user): ?>
                        <li>
                            <input type="text" class="username-input" data-user-id="<?= htmlspecialchars($user['id']) ?>" value="<?= htmlspecialchars($user['username']) ?>" required>
                            <label>
                                Admin <input type="checkbox" class="admin-checkbox" data-user-id="<?= htmlspecialchars($user['id']) ?>" <?= $user['is_admin'] ? 'checked' : '' ?> >
                            </label>
                            <a href="account.php?id=<?= htmlspecialchars($user['id']) ?>">Bekijk profiel</a>
                            <button type="button" class="toggle-videos-btn" onclick="openVideosModal('<?= $user['id'] ?>')">Bekijk/verwijder video's</button>
                            <div id="modal-<?= $user['id'] ?>" class="admin-modal-overlay" style="display:none;">
                                <div class="admin-modal-content">
                                    <button type="button" class="admin-modal-close-button" onclick="closeVideosModal('<?= $user['id'] ?>')">Sluiten</button>
                                    <h3 style="margin-bottom:12px;">Video's van <?= htmlspecialchars($user['username']) ?></h3>
                                    <?php
                                    $videoQuery = "SELECT * FROM videos WHERE user_id = ?";
                                    $videoStmt = $db->prepare($videoQuery);
                                    $videoStmt->bind_param("i", $user['id']);
                                    $videoStmt->execute();
                                    $videoResult = $videoStmt->get_result();
                                    if ($videoResult->num_rows > 0) {
                                    ?>
                                        <form class="modal" action="" method="post">
                                            <input type="hidden" name="delete_video" value="1">
                                            <div class="admin-modal-video-grid">
                                            <?php while ($video = $videoResult->fetch_assoc()) { ?>
                                                <div class="admin-modal-video-item">
                                                    <input type="checkbox" name="video_ids[]" value="<?= htmlspecialchars($video['id']) ?>" style="display:none;">
                                                    <img class="admin-modal-video-thumbnail" src="../public/uploads/user-thumbnails/<?= htmlspecialchars($video['thumbnail']) ?>" alt="thumb">
                                                    <span><?= htmlspecialchars($video['video_title']) ?></span>
                                                    <label>AI <input type="checkbox" class="ai-checkbox" data-video-id="<?= $video['id'] ?>" <?= $video['ai_generated'] ? 'checked' : '' ?> ></label>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <div class="admin-modal-actions">
                                                <button type="submit" name="delete_selected_videos" onclick="return confirmAction('Weet je zeker dat je de geselecteerde video\'s wilt verwijderen?')">Verwijder geselecteerde video's</button>
                                            </div>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <span style="color:var(--muted); font-size:0.95rem;">Geen video's</span>
                                    <?php
                                    }
                                    $videoStmt->close();
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form action="" method="post">
                    <input type="hidden" name="offset" value="<?= htmlspecialchars($offset + $limit) ?>">
                    <button type="submit" name="load_more">Meer laden</button>
                </form>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include('footer.php') ?>
</body>
</html>
