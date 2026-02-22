<?php
// --- BOT CONFIG ---
$token = "8528088909:AAFYlRmpHuFHl8RQAivl435evP1EulfvbTI"; // your bot token
$apiURL = "https://api.telegram.org/bot$token/";

// --- GET UPDATE FROM TELEGRAM ---
$update = json_decode(file_get_contents("php://input"), true);
if (!$update || !isset($update["message"])) { exit; }

$chat_id = $update["message"]["chat"]["id"];

// --- CONNECT TO DATABASE ---
include 'db_connect.php';

// --- SAVE USER CHAT_ID ---
$stmt = $conn->prepare("INSERT IGNORE INTO telegram_users (chat_id) VALUES (?)");
$stmt->bind_param("i", $chat_id);

// Debug logging
if ($stmt->execute()) {
    file_put_contents("debug_log.txt", "Saved chat_id: $chat_id\n", FILE_APPEND);
} else {
    file_put_contents("debug_log.txt", "Failed to save chat_id: $chat_id\n", FILE_APPEND);
}

$stmt->close();

// --- DO NOTHING ELSE (no reply to user) ---
exit;
?>
