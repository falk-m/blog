---
title: 'RevealJs slide show with preact'
taxonomy:
    tag:
        - JS
date: '2024-11-04'
---


## reveal js

I want to create a presentation template for my own.    
Reval js is a nice tool with many features (code highlighting, print view for PDF export, process bar, ...).

For my template, I want to separate slides into different files, but without compiling the source code, when I add new slides.


## ES modules

We should use more often the browsers es-modules feature to load JavaScript.

You can mark content in JS Files as for export:
```js
//demo.js

export default function () {
  return 'foo';
}
```

Then you can access the content from script blocks or in other JS files
```html
    <script type="module">
      import things from "./demo.js"

      console.log(things);
    </script>
```

## preact

Preact is a great project with the same API as react, but with a smaller footprint.
And it could be used without compiling step.

Each slide is in a separate preact component.

```js
//slide/intro.js

import { html } from "../src/html.js";
import { Slide } from "../src/slide.js";

export default function () {
  return html`<${Slide}>
    <h1>Intro</h1>
  <//>`;
}
```

In a summery file are all slides in the right order included:

```js
//slides.js

import { html } from "./src/html.js";
import IntroSlide from "./slides/intro.js";
import OutroSlide from "./slides/outro.js";
import OtherSlide from "./slides/other.js";

export function Slides() {
  return html`<div class="slides">
    <${IntroSlide} />
    <${OtherSlide} />
    <${OutroSlide} />
  </div>`;
}
```

## Demo 

- [Demo](./demo/index.html)
- [Repository on github](https://github.com/falk-m/presentation-template)


## Links

- [ES modules guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules)
- [preactjs](https://preactjs.com/)
- [revealjs](https://revealjs.com/)
