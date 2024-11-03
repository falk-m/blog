```clamp(min(100vw, 30rem), 50vw, 60rem)```
- clamp(MIN, VAL, MAX) is resolved as max(MIN, min(VAL, MAX)).

- nesting ``` a { & b { } }```
- operators ```~```, ```+```
- https://developer.mozilla.org/en-US/docs/Web/CSS/::part


html{
  font-family: arial;
  font-size: clamp(12px, 2vw, 18px);
}