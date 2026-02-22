<?php
$token = "8528088909:AAFYlRmpHuFHl8RQAivl435evP1EulfvbTI";
$apiURL = "https://api.telegram.org/bot$token/";

include 'db_connect.php';
$result = $conn->query("SELECT chat_id FROM telegram_users");

while ($row = $result->fetch_assoc()) {
    $chat_id = $row['chat_id'];

    // --- EDIT THIS MESSAGE FOR NEW ADS ---
    $text = "🔥 New Announcement!\nInvest now and earn daily returns.";
    $keyboard = [
        "inline_keyboard" => [
            [
                ["text" => "⚡ Invest Now,earn more.invite friends and receive more ⚡", "url" => "https://teslainventory.unaux.com/?ref=8"]
            ]
        ]
    ];

    file_get_contents($apiURL . "sendMessage?chat_id=$chat_id&text=" . urlencode($text) .
        "&reply_markup=" . urlencode(json_encode($keyboard)));
}
?>
