<?php
$data = json_decode(file_get_contents('php://input'), true);
$sessionId = $data['sessionId'] ?? '';
if ($sessionId && file_exists("../data/chats/{$sessionId}.json")) {
    unlink("../data/chats/{$sessionId}.json");
}