<?php
header('Content-Type: application/json');

$sessionId = $_GET['session'] ?? '';
$file = "../data/chats/{$sessionId}.json";

if (!file_exists($file)) {
    http_response_code(404);
    echo json_encode(['error' => 'Session not found']);
    exit;
}

$chat = json_decode(file_get_contents($file), true);
$signals = $chat['signals'] ?? [];

// Return first signal and remove it (FIFO)
if (count($signals) > 0) {
    $signal = array_shift($signals);
    $chat['signals'] = $signals;
    file_put_contents($file, json_encode($chat));
    echo json_encode($signal);
} else {
    // No signal yet
    echo json_encode(['type' => 'none']);
}