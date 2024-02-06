<?php

//set header
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");
set_time_limit(0);

while (true) {

    echo "event: date\n";
    echo "data: " . (new DateTime())->format('d.m.Y - H:i:s') . "\n\n";

    ob_flush();
    flush();

    sleep(2);
}
