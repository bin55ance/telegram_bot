<?php
// Include your database connection
require_once("db_connect.php");

// Your bot token
$token = "8327894786:AAEghp4klh-Zg6jwOD2eXyAxlLisitc4ezE";

// Get update from Telegram
$update = json_decode(file_get_contents("php://input"), true);

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text    = $update["message"]["text"];

    // If user clicks Start
    if ($text == "/start") {
        // Save chat_id into telegram_users table (ignore duplicates)
        $stmt = $conn->prepare("INSERT IGNORE INTO telegram_users (chat_id) VALUES (?)");
        $stmt->bind_param("s", $chat_id);
        $stmt->execute();

        // Info message to send
        $info = "👋 Welcome to Tesla Inventory Bot!\n\n"
              . "You are now subscribed to updates.\n\n"
              . "📌 Company Updates\n"
              . "📌 Contact: support@teslainventory.com\n"
              . "📌 Website: https://teslainventory.unaux.com";

        // Send message back to user
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($info));
    }
}
?>
