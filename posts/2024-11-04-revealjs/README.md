---
title: 'RevealJs slide show with preact'
taxonomy:
    tag:
        - JS
date: '2024-11-04'
---


## reveal js

I want to cerate a presentation template for my own.    
Reval js is a nice tool with many features (code highlighting, print view vor pfg export, process bar, ...).

For my template, I want to seperate slides in diffrent files, but without compiling the source code, when i add new slides.


## ES moduels

We should use more often the browsers es-modules feature to load javascript.

You can mark content in js Files as for export:
```js
//demo.js

export default function () {
  return 'foo';
}
```

Then you can access the content from script blocks or in other js files
```html
    <script type="module">
      import things from "./demo.js"

      console.log(things);
    </script>
```

## preact

Preact is a great project with the same api like react, but with a smaller footprint.
And it could be used without compiling step.

each slide is in a seperate preact component.

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

in a summery file are oll slides in the right order included:

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
