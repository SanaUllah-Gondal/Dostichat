<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$sessionId = $_GET['session'] ?? '';
$chatFile = "../data/chats/{$sessionId}.json";

if (!file_exists($chatFile)) {
    http_response_code(404);
    exit;
}

// Simulate partner messages (for demo only)
// In real app: wait for partner's message via DB polling or Redis pub/sub
sleep(2 + rand(0, 3)); // simulate typing

$sampleReplies = [
    "Hi! 👋 How's your day going?",
    "I love biryani too! Do you prefer Sindhi or Hyderabadi style?",
    "Cricket fan? Who’s your favorite player?",
    "We may be from different sides, but our chai tastes the same 😉",
    "Have you read any Faiz Ahmed Faiz? His poetry gives me chills.",
];

$reply = $sampleReplies[array_rand($sampleReplies)];

echo "data: " . json_encode(['type' => 'message', 'text' => $reply]) . "\n\n";
flush();