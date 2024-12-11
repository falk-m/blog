---
title: 'infinity scrolling'
taxonomy:
    tag:
        - JS
date: '2024-12-10'
---

One topic at work last week was to automatic load more items in a list, when the user scroll to the end of the list.
I want to decorate a classic serverside pagination with some javascript to solve this.

First I add a attrebute to the items list to mark them as the items container for seletion later.

```html
<div data-pagination="container">
    <div class="item">...</div>
    <div class="item">...</div>
    <div class="item">...</div>
    <div class="item">...</div>
    <div class="item">...</div>
</div>
```

Then I add also a attrebute on the pagination container and on the link alement with the link for the next page.

```html
<nav data-pagination="paginator">
    <a href="?page=2" data-pagination="link">
        next page
    </a>
</nav>
```

Now the funny part:-)

In the js script, first declare variables for the items container, the pagination container and a variable to memoriece is the loading of the next page already in proces.

```js
let isLoading = false;

const paginator = document.querySelector('[data-pagination="paginator"]');
const container = document.querySelector('[data-pagination="container"]');
```

Then i declare a function to load the html content tring from a url.

```js
const loadContent = function(url){
    let response = await fetch(url);
    if (!response.ok) {
        throw new Error("HTTP error! Status: " + response.status);
    }

    const content = await response.text();

    return content;
};
```

Then we need a function to 
- replace the content of the pagination container with the new pagination content
- append the items from the next page to to current items list

Here I use the DOMParser API to select parts of a html document from a string.

```js
const displayContent(constent){
    const parser = new DOMParser();
    const newDoc = parser.parseFromString(content, "text/html");
    const newContainer = newDoc.querySelector('[data-pagination="container"]');
    const newPaginator = newDoc.querySelector('[data-pagination="paginator"]');

    paginator.innerHTML = newPaginator.innerHTML;
    container.innerHTML = container.innerHTML + newContainer.innerHTML;
}
```

To detect if the paginationcontainer scolled into the viewport, i want to use a IntersectionObserver.
For the observer we net a callback function wich is called, when the observed element leave or enter the viewport.

```js
const callback = async (entries, observer) => {
    const isIntersecting = entries[0].isIntersecting;

    if (isLoading) {
        return;
    }

    if (!isIntersecting) {
        return;
    }

    const link = document.querySelector('[data-pagination="link"]');
    if (!link) {
        return;
    }

    const url = link.getAttribute('href');

    isLoading = true;
    paginator.classList.add('is-loading');

    const content = await loadContent(url);
    displayContent(content);
    
    isLoading = false;
    paginator.classList.remove('is-loading');
};
```

Then start the intersection ovserver on the pagination element.
The root margin option indicates, that the callback shoult be thrown 200px before the pagination element enter the viewport.

```js
const options = {
    root: null,
    rootMargin: '200px',
    threshold: 1
};

const observer = new IntersectionObserver(callback, options);
observer.observe(paginator);
```