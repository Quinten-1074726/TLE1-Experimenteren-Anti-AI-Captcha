<?php
// public/app/video_service.php

/**
 * Haalt video's op met optionele filters.
 *
 * Opties ($opts):
 * - 'search'  : string  (zoekt in video_title & channel_name, LIKE %term%)
 * - 'ai_only' : '1' => alleen AI, '0' => geen AI, anders => geen filter
 * - 'sort'    : 'new' (default) of 'views'
 * - 'limit'   : int (default 30)
 * - 'offset'  : int (default 0)
 *
 * Retourneert: [ 'videos' => array ]
 */
function get_videos(mysqli $db, array $opts = []): array
{
    $search = isset($opts['search']) ? trim((string)$opts['search']) : '';
    $aiOnly = isset($opts['ai_only']) ? (string)$opts['ai_only'] : '';
    $sort   = isset($opts['sort']) ? (string)$opts['sort'] : 'new';
    $limit  = isset($opts['limit']) ? (int)$opts['limit'] : 30;
    $offset = isset($opts['offset']) ? (int)$opts['offset'] : 0;

    $where  = [];
    $types  = '';
    $params = [];

    if ($search !== '') {
        $where[] = '(video_title LIKE ? OR channel_name LIKE ?)';
        $like = '%'.$search.'%';
        $types .= 'ss';
        $params[] = $like;
        $params[] = $like;
    }

    // ai_only interpretatie: '1' => alleen AI, '0' => geen AI, anders negeren
    if ($aiOnly === '1') {
        $where[] = 'ai_generated = 1';
    } elseif ($aiOnly === '0') {
        $where[] = '(ai_generated = 0 OR ai_generated IS NULL)';
    }

    $whereSql = '';
    if (!empty($where)) {
        $whereSql = 'WHERE ' . implode(' AND ', $where);
    }

    $orderBy = 'ORDER BY id DESC'; // default 'new'
    if ($sort === 'views') {
        $orderBy = 'ORDER BY views DESC, id DESC';
    }

    $sql = "SELECT * FROM videos
            $whereSql
            $orderBy
            LIMIT ? OFFSET ?";

    $types .= 'ii';
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $db->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        throw new RuntimeException('Prepare failed: ' . $db->error);
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();

    $videos = [];
    while ($row = $res->fetch_assoc()) {
        $videos[] = $row;
    }

    return ['videos' => $videos];
}
