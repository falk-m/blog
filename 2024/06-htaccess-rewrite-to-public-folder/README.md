---
title: 'Rewrite to public folder'
taxonomy:
    tag:
        - PHP
date: '30-01-2024'
---

If you install the symphony framework or a shopware webshop for example, you have to change the routing on our web server, because the applications require, that the webroot be pointed to the '/public' folder of the project.

in my local environment, I do not like to change this, because I have to change this in my docker file or when I have the web application in a subfolder (like localhost/project1).

Add a '.htaccess' file in the root directory with the following content and it works:

```
RewriteEngine on
RewriteCond %{REQUEST_URI} !public/
RewriteRule (.*) public/$1 [L]
```

**A example**

- I install shopware.
- the shop is now available under 'localhost/public'
- after the installation, I have to change the DocumentRoot in the Apache configuration to '/public'
- I do not change this and add a '.htaccess' file to the DocumentRoot with the above content.
- now the shop is available under 'localhost'


