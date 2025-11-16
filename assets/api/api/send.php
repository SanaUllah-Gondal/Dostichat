<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$sessionId = $data['sessionId'] ?? '';
$text = trim($data['text'] ?? '');

if (!$sessionId || !$text || !file_exists("../data/chats/{$sessionId}.json")) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid session']);
    exit;
}

// Load chat
$chatFile = "../data/chats/{$sessionId}.json";
$chat = json_decode(file_get_contents($chatFile), true);

// Basic moderation: block obvious slurs (expand in prod)
$badWords = ['[slur list]']; // ← Replace with real list or API
if (preg_match('/\b(' . implode('|', $badWords) . ')\b/i', $text)) {
    // Log & skip
    error_log("Blocked message: $text");
    echo json_encode(['blocked' => true]);
    exit;
}

// Save message
$chat['messages'][] = [
    'from' => 'you',
    'text' => htmlspecialchars($text, ENT_QUOTES, 'UTF-8'),
    'ts' => time()
];
file_put_contents($chatFile, json_encode($chat));

// ⚠️ In real app: push to partner's SSE stream via shared storage or DB polling
// For MVP: partner sees messages only when *they* send (simplified)

echo json_encode(['ok' => true]);