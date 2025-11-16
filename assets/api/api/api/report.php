<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$sessionId = $data['sessionId'] ?? '';

if (!$sessionId || !file_exists("../data/chats/{$sessionId}.json")) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid session']);
    exit;
}

$chatFile = "../data/chats/{$sessionId}.json";
$chat = json_decode(file_get_contents($chatFile), true);
$chat['reported'] = true;
$chat['report_reason'] = $data['reason'] ?? 'unspecified';
$chat['reported_at'] = time();

file_put_contents($chatFile, json_encode($chat));

// Log to reports.csv for admin review
file_put_contents('../data/reports.csv', 
    date('Y-m-d H:i:s') . ',' . $sessionId . ',' . $data['reason'] . "\n", 
    FILE_APPEND);

echo json_encode(['success' => true]);