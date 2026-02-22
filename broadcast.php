<?php
// --- BOT CONFIG ---
$token  = "8528088909:AAFYlRmpHuFHl8RQAivl435evP1EulfvbTI"; // your bot token
$apiURL = "https://api.telegram.org/bot$token/";

// --- CONNECT TO DATABASE ---
include 'db_connect.php';

// --- FETCH ALL USERS ---
$result = $conn->query("SELECT chat_id FROM telegram_users");

if ($result && $result->num_rows > 0) {
    $sentCount = 0;
    while ($row = $result->fetch_assoc()) {
        $chat_id = $row['chat_id'];

        // --- EDIT THIS MESSAGE FOR NEW ADS ---
        $text = "🔥 New Announcement!\nInvest now and earn daily returns.";
        $keyboard = [
            "inline_keyboard" => [
                [
                    [
                        "text" => "⚡ Invest Now, earn more. Invite friends and receive more ⚡",
                        "url"  => "https://teslainventory.unaux.com/?ref=8"
                    ]
                ]
            ]
        ];

        // --- SEND MESSAGE ---
        $payload = [
            "chat_id"      => $chat_id,
            "text"         => $text,
            "reply_markup" => json_encode($keyboard)
        ];

        $response = file_get_contents($apiURL . "sendMessage?" . http_build_query($payload));

        $sentCount++;
    }

    // --- SHOW RESULT IN BROWSER ---
    echo "✅ Broadcast sent to $sentCount users.";
} else {
    echo "⚠️ No users found in database.";
}

$conn->close();
?>
