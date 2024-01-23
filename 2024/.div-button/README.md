```js
class DivButton extends HTMLElement {
  connectedCallback() {
    this.setAttribute('role', 'button');
    this.setAttribute('tabindex', '0');

    this.addEventListener('keydown', (e) => {
      console.log(e.key);
      if (e.key === "Enter" || e.key === " ") {
        this.click()
      }
    })
  }
}

customElements.define('div-button', DivButton);
```