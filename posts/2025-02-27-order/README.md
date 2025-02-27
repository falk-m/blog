---
title: 'CSS order property'
taxonomy:
    tag:
        - CSS
date: '2025-02-27'
---

Short CSS thing:

Imagine a CSS flexbox container with three children: 1 | 2 | 3

Did you know that we can change the order of the children by using the ```order``` attribute?

Examples:

```.container div:nth-child(2) { order: -1}``` step the second child one place backward. The result is 2 | 1 | 3.

```.container div:nth-child(2) { order: 1}``` step the second child one place forward. The result is 1 | 3 | 2.

You can also set each position manual with this property.    
```.container div:nth-child(1) { order: 2}```    
```.container div:nth-child(2) { order: 3}```    
```.container div:nth-child(3) { order: 1}```    
The result is: 3 | 1 | 2

- [Example](./example.html)