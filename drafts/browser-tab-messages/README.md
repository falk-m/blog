

```js
var _send_excange_event = (name: string, value: string | null = null) => {
    localStorage.setItem('exchange', JSON.stringify({event: name, date: Date.now().toString(), value: value}));
    localStorage.removeItem('excange');
}
```

```js
window.addEventListener('storage', function(event) {
    //sync auth token in session storage over local torage

    if (event.key !== 'exchange' || !event.newValue){
        return;
    }

    var data = JSON.parse(event.newValue);

    switch (data.event) {
        case "hello":
            if(sessionStorage.getItem("auth_token")){
                _send_excange_event("login", sessionStorage.getItem("auth_token"));
            }
            break;
        case "login":
            store.dispatch(setToken(data.value));
            break;
        case "logout":
            store.dispatch(logout());
            break;
    }
});
```

```js
 var token = sessionStorage.getItem('auth_token') || '';

if(!token || !this.validateToken(token)) {
    // Ask other tabs for session storage
    localStorage.setItem('exchange', JSON.stringify({event: "hello", date: Date.now().toString(), value: ""}));
    localStorage.removeItem('excange');
}
```

## information

- https://developer.mozilla.org/en-US/docs/Web/API/Window/storage_event