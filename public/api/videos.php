<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../app/video_service.php';

try {
    $s       = $_GET['s']       ?? '';
    $ai_only = $_GET['ai_only'] ?? '';     
    $sort    = $_GET['sort']    ?? 'new';   
    $limit   = isset($_GET['limit'])  ? max(1, (int)$_GET['limit'])  : 30;
    $offset  = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;

    $data = get_videos($db, [
        'search'  => $s,
        'ai_only' => $ai_only,
        'sort'    => $sort,
        'limit'   => $limit,
        'offset'  => $offset,
    ]);

    echo json_encode([
        'ok'      => true,
        'limit'   => $limit,
        'offset'  => $offset,
        'count'   => count($data['videos']),
        'videos'  => $data['videos'],
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok'    => false,
        'error' => $e->getMessage(),
    ]);
}
