---
title: 'react hooks'
taxonomy:
    tag:
        - JS
date: '2024-11-02'
---

## useRef

Sometimes is see that someone use useRef in situations i would use 'useState'.

```js
const blocking = React.useRef(false);

const onScroll = () => {
      if (!blocking.current) {
        blocking.current = true;
        ...
      }
    };
```

One of the main diffrence is that changing the value of a ref don't trigger a re-rendering.

- [useRef api reference](https://react.dev/reference/react/useRef)
- [useState api reference](https://react.dev/reference/react/useState)

## custom hooks

 Robin Wieruch write create articels to create and usage of custom hooks.

- [React: How to create a Custom Hook](https://www.robinwieruch.de/react-custom-hook/)
- [React Hook: Check if Overflow](https://www.robinwieruch.de/react-custom-hook-check-if-overflow/)
- [React Hook: useLocalStorage](https://www.robinwieruch.de/react-uselocalstorage-hook/)

## state and context

- [How to useContext in React](https://robinwieruch.de/react-usecontext-hook/)
- [Zustand](https://github.com/pmndrs/zustand): react light global state managment alternative to redux