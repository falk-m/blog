---
title: 'underrated html elements'
taxonomy:
    tag:
        - HTML
date: '2025-06-30'
---

## dl element

Represents a description list, includes a list of terms and there description.

## Examples

<dl>
  <dt>dl - description list</dt>
  <dd>the lst element</dd>

  <dt>dt - descriped term</dt>
  <dd>the term</dd>

  <dt>dd - term desctiption</dt>
  <dd>the description of the term</dd>
</dl>

```html
<dl>
  <dt>dl - description list</dt>
  <dd>the lst element</dd>

  <dt>dt - descriped term</dt>
  <dd>the term</dd>

  <dt>dd - term desctiption</dt>
  <dd>the description of the term</dd>
</dl>
```


## time element

Translate dates into machine-readable format. For better search engine results or custom features such as reminders.
Represents a time (24-houre clock), a date (gregorian calendar, optional with time and timezone) or a time duration.

### Examples

<time datetime="2018-07-07">July 7</time>, starts at <time datetime="20:00">20:00</time>, duration <time datetime="PT2H30M">2h 30m</time>

```html
<time datetime="2018-07-07">July 7</time>, starts at <time datetime="20:00">20:00</time>, duration <time datetime="PT2H30M">2h 30m</time>
```

##  Text inline element

<ul>
    <li>
        <mark>This text</mark> is marked. It is highlighted to marke the relevance in the enclosing context.
    </li>
    <li>
        "the cite tag is used to mark up the title of a creative work" source <cite>mozilla.org</cite>
    </li>
    <li>
       <em>em</em> emphasis compared to surrounding text
    </li>
    <li>
        You could use the u-element to highlight <u>speling</u> mistakes<u></u>
    </li>
    <li>
        <del>This Text</del> is removev and <ins>this text</ins> is new.
    </li>
</ul>

```html
<ul>
    <li>
        <mark>This text</mark> is marked. It is highlighted to marke the relevance in the enclosing context.
    </li>
    <li>
        "the cite tag is used to mark up the title of a creative work" source <cite>mozilla.org</cite>
    </li>
    <li>
       <em>em</em> emphasis compared to surrounding text
    </li>
    <li>
        You could use the u-element to highlight <u>speling</u> mistakes<u></u>
    </li>
    <li>
        <del>This Text</del> is removev and <ins>this text</ins> is new.
    </li>
</ul>
```

## Small element

Represents side-comments and small print, like copyright and legal text.

<small>This text</small> is small.

```html
<small>This text</small> is small.
```

## Sub and sup

These elements should only be used for typographical reasons.
They lowered or raised the baseline of the text using smaller text.

<sub>This text</sub> is in a sub element and <sup>this text</sup> in a sup element.

```html
<sub>This text</sub> is in a sub element and <sup>this text</sup> in a sup element.
```


## links

- [dl element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dl)
- [mark element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/mark)
- [time element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/time)
- [u element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/u)
- [del and ins element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/del)
- [cite element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/cite)
- [em element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/em)
- [small element on mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/small)