---
title: 'Broadcast challen api'
taxonomy:
    tag:
        - JS
date: '2024-02-26'
---

In a post from 2024-02-08, I describe a way to send messages between the scripts in different browser windows with a storage event.

Now I have found a smarter solution for this problem:
The [Broadcast Channel API}(https://developer.mozilla.org/en-US/docs/Web/API/Broadcast_Channel_API).

First step is to init a channel object with the name of the selected channel:
```JS
const bc = new BroadcastChannel("test_channel");
```

The 'onmessage' callback receives the messages sent to the channel.
conveniently, it doesn't receive own messages.
You can use different BroadcastChannel objects to send and receive messages in the same window.

```JS
bc.onmessage = (event) => {
    console.log(event.data);
};
```

The 'postMessage' method sent messages to other subscribers.
```JS
bc.postMessage("This is a test message.");
```

You can also send objects.
```JS
bc.postMessage({x: "This is a test secound message."});
```

If you want to close the subscription use the 'close' method.
```JS
bc.close();
```