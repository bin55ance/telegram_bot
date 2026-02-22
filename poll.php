<?php
// --- BOT CONFIG ---
$token = "8528088909:AAFYlRmpHuFHl8RQAivl435evP1EulfvbTI";
$apiURL = "https://api.telegram.org/bot$token/getUpdates";

// --- FETCH UPDATES ---
$response = file_get_contents($apiURL);
$updates = json_decode($response, true);

// --- CONNECT TO DATABASE ---
include 'db_connect.php';

if (isset($updates["result"])) {
    foreach ($updates["result"] as $update) {
        if (isset($update["message"])) {
            $chat_id = $update["message"]["chat"]["id"];

            // Save chat_id safely
            $stmt = $conn->prepare("INSERT IGNORE INTO telegram_users (chat_id) VALUES (?)");
            $stmt->bind_param("s", $chat_id); // use string for BIGINT
            if (!$stmt->execute()) {
                file_put_contents("poll_errors.txt", "Insert failed for $chat_id: " . $stmt->error . "\n", FILE_APPEND);
            }
            $stmt->close();

            // Acknowledge this update so Telegram doesn’t resend it
            $lastUpdateId = $update["update_id"];
        }
    }

    // Clear the queue up to the last update
    if (isset($lastUpdateId)) {
        file_get_contents("https://api.telegram.org/bot$token/getUpdates?offset=" . ($lastUpdateId + 1));
    }

    echo "Users saved!";
} else {
    echo "No updates found.";
}

$conn->close();
?>
