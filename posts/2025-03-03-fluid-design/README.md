---
title: 'Fluid-design'
taxonomy:
    tag:
        - CSS
date: '2025-03-05'
---

Fluid-design want to implement a responsive design without using of media queries.

Try the [Demo](./demo.html) on your desktop pc and play with font size and window width.

## Padding

A normal padding looks nice on wide screen.

```css
.p-1 {
    padding: 4rem;
}
```

But on small screens 4rem could be 33% of the total width.    
Use the min function to reduce the width on small screens. 

```css
.p-1 {
    padding: min(4rem, 8vw)
}
```

## Font size

In some cases a headline looks good when the font size is calculated in the screen width. 

```css
.headline {
    font-size: 6vw;
}
```

But on small screens is the text to small and on ultrawide screens to big.     
```clam``` is useful to set borders in both directions.

```css
.headline {
    font-size: clamp(2rem, 6vw, 6rem);
}
```

The rem unit only depends on the viewport and not on the zoom level or font-size.    
Mix in a part of a zoomable unit like rem or px for better accessibility.

```css
.headline {
    font-size: clamp(2rem, 4vw + 2em, 6rem)
}
```

## view height

keep in mind that on mobile phones 100vh could be included the browser bar.    
'dvh' is the dynamic unit how only means the visible document height.    
Firefox currently not support this unit, so provide a fallback.    

```css
.box {
    height: 100vh;
    height: 100dvh;
}
```

## Wrapper

An example for a fluid centered container with space around them.

```css
.wrapper {
    margin-inline: auto;
    width: min(90rem, 100% - 8vw);
}
```

## Rows 

Make that main element no wider than 60 characters and no narrower than 20 characters for better reading.

Here is a fluid example of a row with two boxes. First box is twice as wide the other one.
When one box is too small, the second box swap to an own row.

```css
.wrapper {
   display: flex; 
    flex-wrap: wrap;
    gap: clamp(1.125rem, 0.6467rem + 2.3913vw, 2.5rem);
    padding: clamp(0.5rem, 0.1522rem + 1.7391vw, 1.5rem);
}

.box-right {
    flex-basis: 40rem; 
    flex-grow: 2;
}

.box-left {
    flex-basis: 40rem; 
    flex-grow: 1;
}
```

## Grid

A great example from Kevin Powell for a simple grid:

```css
 .auto-grid {
    --min-column-size: 22rem;

    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(min(var(--min-column-size), 100%), 1fr));

    > * {
        background-color: aqua;
        padding: 1rem;
    }
}
```

## links

- [Demo](./demo.html)
- [utopia.fyi](https://utopia.fyi/)
- [CSS tips for responsive web design](https://www.youtube.com/watch?v=2IV08sP9m3U)
- [Useful & Responsive Layouts, no Media Queries required](https://www.youtube.com/watch?v=p3_xN2Zp1TY)
- [responsive-design](https://ishadeed.com/article/responsive-design/#fluid-sizing)