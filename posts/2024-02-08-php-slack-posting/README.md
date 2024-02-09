---
title: 'Post messages to Slack Channel'
taxonomy:
    tag:
        - PHP
date: '2024-02-08'
---

## find the channel id

There are many ways to find the channel id.
The simplest is, to use the Slack browser application and copy the channel id from the URL after you enter the channel.
The URL looks like ```https://app.slack.com/client/xxx/C0XXXXXXXX```.
The Channel id is the last segment, starting with a 'C'.

## Create api token

### 1. visit the info page

[https://api.slack.com/tutorials/tracks/posting-messages-with-curl](https://api.slack.com/tutorials/tracks/posting-messages-with-curl)

### 2. click "Create app"

![start page with button](./website_start.png)

### 3. follow the instructions

Select the workspace and make sure there are the right scopes: chat:write, chat:write.public

![select a workspace](./select_workspace.png)

### 4. execute the "Install your app" step

![install workspace](./install_workspace.png)

### 5. go back
At the end, there is an overlay on top of the page with the headline "Your're all set for now!".
Press the link "Posting messages using curl" and get back to the page from step 1.

![page after creating the app](./init_app_finish.png)

### 6. copy token.

You are back on the "Posting messages using curl".
The "Create app" is gone.
There is now a black box with your token.

![a website with token](./display_token.png)

## post a message

```php
$channelId = "Cxxxxxxxxxx";
$token = "xoxb-xxxxxxx-xxxxxx-xxxxxx";

$ch = curl_init();

$message = [
    "channel" => $channelId,
    "blocks" => [
        [
            "type" => "section",
            "text" => [
                "type" => "mrkdwn",
                "text" => "This is a *test-message*"
            ]
        ]
    ]
];

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
```