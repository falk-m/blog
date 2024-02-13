---
title: 'session management with tokens'
tag:
    - SECURITY
date: '2024-02-13'
---

This Post is not about OAuth.
The inspected use case is the session management for an API after the authentification (after login).
It is not about the authentification process, code flow, and so on.

In a simple case, the API sets a session cookie after login:

**Pros:**
- the browser sends with each request the cookie to the API.
- the browser deletes the session cookie when the user closes the browser.
- client site scripts in the browser do not have access to the cookie content

**cons**
- a client application in the browser can not the status of the session
- a "stay logged in" is not possible without a long-lived cookie
- the token is not usable on another resource server 

## a token-based approach

**Access token**
- is needed to access resources, e.g. to call an API
- is a short-lived token. The token is 10 minutes valid.
- it's a JWT. so the client has access to the data in the token (user name, ...) and can check the expiration date.

**login**
- after successfully authentification (username/password, two-factor, ... ) the server response
  - an access token
  - a refresh token

**refresh token** 

- it's also a JWT
- with the same lifetime as the access token
- used to generate a new access token

**refresh the tokens**

- send the current refresh-token to a refresh endpoint (/refresh)
- receive a fresh access token and a new refresh token


**refresh token rotation**

- security feature
- when calling the refresh endpoint
    - Invalidate all previous access tokens and refresh-token, based on the same origin login (token family)
- if an attacker uses an invalid refresh token
    - Invalidate all tokens from all token families

**stay logged in**

- when the user selects the "stay logged in" feature by login, then the refresh token gets a long lifetime (e.g. 3 months) 

**Logout**

- Invalidate all tokens from the same token family

**security**

- use refresh token rotation 
- never expose tokens in a URL
- when the login server and resource server are different servers use public-private key encryption to signate and verify the access-token  