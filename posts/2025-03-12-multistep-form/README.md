---
title: "create a multistep form"
taxonomy:
  tag:
    - JS
date: "2025-03-12"
---

I want to create a multistep HTML form. That means you have to input some data to access the next step and so on, until you can submit the form in the last step.

Requirements:

- form is normal usable when JS is disabled
- form is accessible (keyboard navigation, focus handling, ...)
- use native form validation

## Form navigation 

All non-active form steps would be set invisible:

```js
const $form = document.querySelector(formSelector);
const steps = $form.querySelectorAll(formStepSelector);

const changeStepVisibility = (stepIdx) => {
  steps.forEach((container, containerIdx) => {
    if (stepIdx != containerIdx) {
      container.style.display = "none";
      return;
    }
    container.style.display = "block";
  });
};
```

Caution: Set a 'aria-hidden' attribute if you want to use other technics to hide other form steps.
See [here](https://developer.mozilla.org/de/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-hidden)

## change focus

After navigation in the form steps set the focus on the first visible input element:

```js
 const changeStepFocus = (stepIdx) => {
  const focusElement = steps[stepIdx].querySelector(
    "input,textarea,button"
  );
  if (focusElement) {
    setTimeout(() => {
      focusElement.focus();
    }, 100);
  }
};
```

## Form validation

It makes no sense to validate the next steps.
Here is an example to validate only inputs in the visible container:

```js
const elementsToValidate =  activeElement.querySelectorAll("input, textarea");
let hasError = false;

elementsToValidate.forEach((element) => {
    if (!element.checkValidity()) {
      if (element.reportValidity) {
        element.reportValidity();
      }
      hasError = true;
    }
});
```

So we validate the visible step when the user click on the navigation buttons for the next step or submit the form:

```js

btnNext.addEventListener("click", () => {
  const activeStep = $form.activeStep || 0;

  if (!isStepValid(activeStep)) {
    return;
  }

  $form.displayStep(activeStep + 1);
});

$form.addEventListener("submit", (evt) => {
  
    const activeStep = $form.activeStep || 0;
    
    if (!isStepValid(activeStep)) {
      evt.preventDefault();
      return false;
    }

    if (activeStep < steps.length - 1) {
      evt.preventDefault();
      $form.displayStep(activeStep + 1);
      return false;
    }

    return true;
});
```

When the user submits the form by press the enter key, then the browsers native form validation validate the hole form,
before the submit event is fired. 
That's a problem. And the browser raise an exception 'An invalid form control is not focusable'.    
To prevent this use ```$form.setAttribute('novalidate', true);``` to disable the hole form validation recourse we validate it part by part.

## Demo

Visit here the [Demo](./demo.html) and the complete source code (in the same html file).

