<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection
require_once("db_connect.php");

// Your bot token
$token = "8327894786:AAEghp4klh-Zg6jwOD2eXyAxlLisitc4ezE";

// Message you want to broadcast
$message = "🚨 Tesla Inventory Update!\n\nCheck our site: https://teslainventory.unaux.com";

// Function to send message using cURL
function sendMessage($token, $chat_id, $message) {
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text'    => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch) . "<br>";
    } else {
        echo "Sent to $chat_id: $response<br>";
    }

    curl_close($ch);
    return $response;
}

// Get all users from telegram_users table
$result = $conn->query("SELECT chat_id FROM telegram_users");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chat_id = $row['chat_id'];
        sendMessage($token, $chat_id, $message);
    }
    echo "Broadcast sent to all users!";
} else {
    echo "No users found in telegram_users table.";
}
?>
