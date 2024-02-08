---
title: 'Messages between browser tabs'
taxonomy:
    tag:
        - JS
date: '2024-02-08'
---

in some cases, it is necessary to sync browser tabs or send a message to another tab.
For example: In one tab is a voice recorder and in the other is a list of recordings. When the record is finished, then the list should be refreshed.
Another example could be after a login, other tabs should be informed.

Here is a code example. I store an API token after a login in the session storage.
The session-storage has the advantage, that it is cleared after the browser is closed.
But the disadvantage is, that the session store has its own scope for each tab of the same site.

To inform the other tabs we use the feature of the storage event.
[https://developer.mozilla.org/en-US/docs/Web/API/Window/storage_event](https://developer.mozilla.org/en-US/docs/Web/API/Window/storage_event)

If in one tab is anything changed in the local storage, the event is fired in all tabs of the same host.

So we can define an exchange event to send a message with a name and a value to all tabs.
After that, we remove the message.

```js
var _send_exchange_event = (name: string, value: string | null = null) => {
    localStorage.setItem('exchange', JSON.stringify({event: name, date: Date.now().toString(), value: value}));
    localStorage.removeItem('excange');
}
```

We subscribe to changes in storage with the 'exchange' storage key.

If the message name is 'hello', then the message is from a new browser tab, which looks for other tabs with a valid token for him.
If the tab has a token, he sends back a 'login' message with the token.
If the tab receives a 'login' message from another tab with a token, then he stores the token.
If the tab receives a logout message from another tab, then he also removes his token.

```js
window.addEventListener('storage', function(event) {
    //sync auth token in session storage over local torage

    if (event.key !== 'exchange' || !event.newValue){
        return;
    }

    var data = JSON.parse(event.newValue);

    switch (data.event) {
        case "hello":
            if(sessionStorage.getItem("token")){
                _send_exchange_event("login", sessionStorage.getItem("token"));
            }
            break;
        case "login":
            sessionStorage.setItem("token", data.value));
            break;
        case "logout":
            sessionStorage.removeItem("token");
            break;
    }
});
```

When a new tab is opened, it sends a 'hello' message and hopes there is another tab that sends a token back.
```js
 var token = sessionStorage.getItem('auth_token') || '';

if(!token || !this.validateToken(token)) {
    // Ask other tabs for session storage
    _send_exchange_event('hello')
}
```

After login, the tab informs same other tabs about the new token
```js
    _send_exchange_event("login", new_token);
```

After a logout, the tab informs same other tabs about this.
```js
    _send_exchange_event("logout");
```

this is a very basic example.
In real cases, you not only update the session storage. you also update a react state for example, redirect the user, display a message or something else.


## information

- https://developer.mozilla.org/en-US/docs/Web/API/Window/storage_event