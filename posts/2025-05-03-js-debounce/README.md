---
title: 'JS Debounce and Throttle functions'
taxonomy:
    tag:
        - JS
date: '2025-05-03'
---

## Debounce

limiting function executions for automate search inputs for example or resize events

```js
function debounce(func, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => func.apply(this, args), delay);
  };
}

// Example usage:
window.addEventListener('resize', debounce(() => {
  console.log('Window resized');
}, 500));
```

## Throttle

like debounce-function, but first execution trigger the event:  

 ```js
 function throttle(func, delay) {
  let lastTime = 0;
  return function (...args) {
    const now = new Date().getTime();
    if (now - lastTime >= delay) {
      func.apply(this, args);
      lastTime = now;
    }
  };
}

// Example usage:
window.addEventListener('scroll', throttle(() => {
  console.log('Scroll event triggered');
}, 500));
```

## links

- [6-powerful-javascript-functions](https://dev.to/nozibul_islam_113b1d5334f/master-6-powerful-javascript-functions-599b)