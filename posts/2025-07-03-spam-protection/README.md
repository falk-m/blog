---
title: 'spam protection in web forms'
taxonomy:
    tag:
        - OTHER
date: '2025-07-03'
---

## Duration

In one of my last meetups, someone how run a personal website reported this positive experiences with the (WordPress Antispam Bee)[https://wordpress.org/plugins/antispam-bee/] plugin.
I read the description and find an interesting aspect.
The plugin considers the comment time.

That's a nice idea for web forms!
A bot only needs a few milliseconds to request a form how a human needs minutes.

Solution: 
When the webpage is loaded, the time is stored in a server side session related to a cookie.
After the forms submit, the server calculate the time difference and decline the request,
when the user only needs a few seconds to fill out the form.

## Honeypot

An old but also robust solutions are honeypots.
A form includes a for humans non-visible input field.
When the field is not empty in the server request, then the request come from a bot.

## CSRF token

A CSRF token is not a solution for bot detection, but good to protect the website users.
The objective is to prevent manipulative requests with the users' session.
CSRF tokens often obligatory for POST-, PUT-, PATCH- or DELETE request.
The web server create a random token and store them in the session.
When the user open a form, the token is inserted in a hidden form field or is appended on the action URL.
The request have to obtain the token in the request (content or query parameter).
If the submitted token not equals the token in the session, then the request is not from the current site view.

## Captchas 

Proof-of-work CAPTCHA aims to increase the effort for bots to craws web pages.
This could also be a good solution for form requests.

- [captchas-are-over](https://behind.pretix.eu/2025/05/23/captchas-are-over/): CAPTCHAs are over (in ticketing)
- [friendly-challenge](https://github.com/FriendlyCaptcha/friendly-challenge): The widget and docs for the proof of work challenge used in Friendly Captcha.
- [anubis](https://github.com/TecharoHQ/anubis): Weighs the soul of incoming HTTP requests to stop AI crawlers
- [capjs.js](https://capjs.js.org/): A modern, lightning-quick PoW captcha
- [p-captcha](https://p-captcha.com/): Proof-of-work CAPTCHA for bot protection
- [altcha](https://altcha.org/): Next-Gen Captcha and Spam Protection
- [pow-bot-deterrent](https://github.com/sequentialread/pow-bot-deterrent): A proof-of-work based bot deterrent.