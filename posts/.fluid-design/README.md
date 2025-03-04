---
title: 'fluid design'
taxonomy:
    tag:
        - CSS
date: '2025-03-05'
---

## padding

```css
.p-1 {
    padding: 4rem;
}
```


```css
.p-1 {
    padding: min(4rem, 8vw)
}
```

## font size



```css
.headline {
    font-size: 6rem;
}
```

```css
.headline {
    font-size: clamp(1.8, 10vw, 6rem);
}
```

Can not zoom. Need a part of a zoomable unit like rem or px:


```css
.headline {
    font-size: clamp(1.8, 7vw + 1rem, 6rem);
}
```

## view height

```css
.box {
    height: 100vh;
    height: 100dvh;
}
```

## links

- [utopia.fyi](https://utopia.fyi/)
- [CSS tips for responsive web design](https://www.youtube.com/watch?v=2IV08sP9m3U)