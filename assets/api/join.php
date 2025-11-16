<?php
header('Content-Type: application/json');
session_start();

// Simulate session ID (in prod: use DB)
$sessionId = bin2hex(random_bytes(8));
$partnerId = bin2hex(random_bytes(8));

// Store in temporary file (replace with Redis/DB later)
file_put_contents("../data/chats/{$sessionId}.json", json_encode([
    'id' => $sessionId,
    'partner' => $partnerId,
    'created' => time(),
    'interests' => $_POST['interests'] ?? 'general',
    'messages' => [],
    'reported' => false
]));

echo json_encode(['success' => true, 'sessionId' => $sessionId]);