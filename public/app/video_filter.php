<?php
// Filter functie videos of kanaal naam 

function filter_videos(mysqli $db, ?string $s = null, int $limit = 60, int $offset = 0): array {
    $s = trim((string)$s);

    if ($s === '') {
        $stmt = $db->prepare("SELECT * FROM videos ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $limit, $offset);
    } else {
        $like = '%'.$s.'%';
        $stmt = $db->prepare("
            SELECT *
            FROM videos
            WHERE video_title LIKE ? OR channel_name LIKE ?
            ORDER BY id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param('ssii', $like, $like, $limit, $offset);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $videos = [];
    while ($row = $res->fetch_assoc()) {
        $videos[] = $row;
    }
    return $videos;
}
