---
title: 'Twind - Tailwind in js'
taxonomy:
    tag:
        - JS
date: '2025-02-16'
---

A nice solution to use tailwind without a NodeJS watcher process or the tailwind sandbox scripts is a completely JS solution, that work directly in the browser.
And the file size is very small, only 10kb.

```html
<script src="https://cdn.jsdelivr.net/npm/@twind/core@1"></script>
    <script>
      twind.install({
        hash: false
      })
    </script>

<h1 class="m-4 text-2xl font-medium">Test</h1>
```

## Links

- [twind.style](https://twind.style/)
- [configuration](https://twind.dev/handbook/configuration.html)