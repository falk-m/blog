---
title: 'responsive font-size'
taxonomy:
    tag:
        - CSS
date: '2024-04-02'
---

Here are three simple lines of code to smooth sizing the root font size depends on the screen size.

```css
:root {
    font-size: calc(1rem + 0.25vw);
}
```

You can also use 'clamp' to use the smooth sizing only between 380px and 1240px:

```css
:root {
  --fluid-16-20: clamp(1rem, 0.8895rem + 0.4651vi, 1.25rem);
}
```

## Source

- [jameshfisher.com](https://jameshfisher.com/2024/03/12/a-formula-for-responsive-font-size/)
- [utopia.fyi](https://utopia.fyi/clamp/calculator?a=380,1240)