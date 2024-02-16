---
title: "Server side events with php"
taxonomy:
    tag:
        - PHP
        - JS
date: "2024-02-06"
---

There are different ways for near real-time browser updates by a server message.
With a PHP website on the server side, you are very restricted, because in normal case you can't run a web socket process or something else.
In the past, the simplest way was to use long polling.
Long polling means:

- the client side init an Ajax call to the webserver
- the webserver runs an infinity loop until the event has occurred, like a new database entry
- the webserver responds to the client
- the client received the data
- the client init an Ajax call to the server
- ...

if you use long polling, you have to implement the handling around your main logic
to handle and reconnect by connection interruption and so on.

With the EventSource Object, javascript now supports this more elegantly.

on the server side, it is like long polling.
you have to add some headers and can send data to the client without closing the connection.

```php
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
```

Here is a client-side JS example:

```js
if (!window.EventSource) {
    alert("Server-Sent Events not supported");
    return;
}

const eventSource = new EventSource("server.php");

eventSource.addEventListener("date", function (event) {
    console.log(event.data);
});

eventSource.addEventListener("end", function (event) {
    eventSource.close();
});

eventSource.addEventListener("error", function (event) {
    if (event.readyState === EventSource.CLOSED) {
    console.log("Fehler aufgetreten - die Verbindung wurde getrennt.");
    }
});

```


## links and more information

- https://developer.mozilla.org/en-US/docs/Web/API/EventSource
- https://www.codemag.com/Article/2312051/Introduction-to-Real-Time-Communication-in-PHP-Laravel
- https://www.codingblatt.de/html5-server-sent-events/
- https://caniuse.com/?search=EventSource
