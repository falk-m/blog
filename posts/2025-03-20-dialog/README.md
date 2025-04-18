---
title: "html dialog element demo"
taxonomy:
  tag:
    - JS
    - CSS
    - HTML
date: "2025-03-20"
---

[Visit demo](./demo.html)

---

## standard dialog

A dialog element is hidden by default.

`.showModal()` open the centered dialog and add a Backdrop element.

`.show()` open the dialog on top position and don't add a Backdrop element.

```html
<dialog id="dialog">Standard Dialog Content</dialog>
<button id="btn">Open Standard Dialog</button>

<script>
  document.querySelector("#btn").addEventListener("click", () => {
    const dialog = document.querySelector("#dialog");
    dialog.showModal();
  });
</script>
```

## close button

Use the dialog `.clode()` method.

```html
<button type="button" id="btn-close">close</button>

<script>
  document.querySelector("#btn-close").addEventListener("click", () => {
    const dialog = document.querySelector("#dialog");
    dialog.close();
  });
</script>
```

## Close on backdrop click

A click on the backdrop pseudo-element is also a click on the dialog itself.
Wrap the dialog content in other element (e.g. div-box). 
Then you can detect in the click event if the clicked element the content of the dialog or the dialog itself (also the backdrop element).

```html
<dialog id="dialog">
  <div>Standard Dialog Content</div>
</dialog>

<script>
  document.querySelector("#dialog").addEventListener("click", (event) => {
    if (event.target.tagName.toLowerCase() === "dialog") {
      event.target.close();
    }
  });
</script>
```

## style backdrop

The dialog has a `::backdrop` pseudo-element.

```css
dialog:open::backdrop {
  background-color: rgb(0 0 0 / 25%);
}
```

## Slide in dialog

Use `dialog:not([open])` and `dialog[open]` selectors for animation.

```css
dialog {
  position: fixed;
  top: 0;
  right: 0;
  left: auto;
  height: 100vh;

  --duration: 1s;
  transition: 
    transform var(--duration) ease-in-out, 
    display var(--duration) ease-in-out allow-discrete;
}

dialog:not([open]) {
  transform: translateX(100%);
}

dialog[open] {
  transform: translateX(0%);

  @starting-style {
    transform: translateX(100%);
  }
}
```

## keep in mind the client standard styling 

If you like to use die dialog with full `width` or `height`, please note to override standard `max-width` and `max-height` values.

```css
dialog {
    position: fixed;
    inset-block-start: 0px;
    inset-block-end: 0px;
    max-width: calc(100% - 2em - 6px);
    max-height: calc(100% - 2em - 6px);
    user-select: text;
    visibility: visible;
    overflow: auto;
}
```

---

[Visit demo](./demo.html)
