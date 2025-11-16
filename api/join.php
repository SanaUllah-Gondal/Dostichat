<?php
header('Content-Type: application/json');
session_start();
\ = bin2hex(random_bytes(8));
echo json_encode(['success' => true, 'sessionId' => \]);
?>
