<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = require(__DIR__ . "/config.php");
$channelId = $config["channel_id"];
$token = $config["token"];

echo "curl -H \"Authorization: Bearer {$token}\" https://slack.com/api/auth.test\n\n";

/*
curl -H "Content-type: application/json" \
--data '{"channel":"C123456","blocks":[{"type":"section","text":{"type":"mrkdwn","text":"Hi I am a bot that can post *_fancy_* messages to any public channel."}}]}' \
-H "Authorization: Bearer xoxb-not-a-real-token-this-will-not-work" \
-X POST https://slack.com/api/chat.postMessage
*/

$ch = curl_init();

$message = [
    "channel" => $channelId,
    "blocks" => [
        [
            "type" => "section",
            "text" => [
                "type" => "mrkdwn",
                "text" => "This is a *test-message* from the Jobadvertiser backend"
            ]
        ]
    ]
];

print_r($message);

curl_setopt_array($ch, [
    CURLOPT_URL => "https://slack.com/api/chat.postMessage",
    CURLOPT_HEADER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json; charset=UTF-8',
        "Authorization: Bearer {$token}"
    ],
    CURLOPT_POSTFIELDS => json_encode($message)
]);

$content = curl_exec($ch);
$header  = curl_getinfo($ch);

header("Content-Type: text/plain");
echo "Header\n";
print_r($header);

echo $header["http_code"] == 200 ? "SUCCESS" : "ERROR";

echo "\n\nContent\n";
print_r($content);

$json = json_decode($content, true);
if (\JSON_ERROR_NONE !== \json_last_error() || !is_array($json)) {
    echo "JSON ERROR";
    exit;
}

echo ($header["ok"] ?? false) ? "SUCCESS" : "ERROR";
