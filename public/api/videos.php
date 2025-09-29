<?php
// Simple JSON endpoint for listing videos.
// Optional query param: ai_only=1 to return only ai_generated = 1 rows.

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../database/connection.php';
/** @var mysqli $db */

// Basic allow list of columns to return (explicit for clarity & future extension)
$columns = [
    'id', 'video_title', 'video_description', 'thumbnail', 'user_id', 'date', 'views',
    'created_at', 'updated_at', 'file_path', 'ai_generated', 'channel_name'
];

$aiOnly = isset($_GET['ai_only']) && $_GET['ai_only'] === '1';

$sql = 'SELECT ' . implode(',', $columns) . ' FROM videos';
if ($aiOnly) {
    $sql .= ' WHERE ai_generated = 1';
}
$sql .= ' ORDER BY id DESC';

$result = mysqli_query($db, $sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed', 'details' => mysqli_error($db)]);
    exit;
}

$videos = [];
while ($row = mysqli_fetch_assoc($result)) {
    // If thumbnail is stored as blob, you may need a path; assume existing code expects filename in 'thumbnail'
    $videos[] = $row;
}

echo json_encode(['videos' => $videos]);
exit;
?>