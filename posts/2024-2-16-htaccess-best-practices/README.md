---
title: 'htaccess best practices'
taxonomy:
    tag:
        - PHP
        - SECURITY
date: '2024-02-16'
---

## SEO and performance

set expiration header
```php
<IfModule mod_expires.c>
	ExpiresActive On
	ExpiresDefault "access plus 1 week"
	ExpiresByType text/html "access plus 600 seconds"
	ExpiresByType text/plain "access plus 0 seconds"
	ExpiresByType text/xml "access plus 0 seconds"
	ExpiresByType text/css "access plus 1 week"
	ExpiresByType image/gif "access plus 1 week"
	ExpiresByType image/png "access plus 1 week"
	ExpiresByType image/jpg "access plus 1 week"
	ExpiresByType image/jpeg "access plus 1 week"
	ExpiresByType image/x-icon "access plus 4 week"
	ExpiresByType image/svg+xml "access plus 4 weeks"
	ExpiresByType video/mp4 "access plus 4 weeks"
	ExpiresByType video/ogg "access plus 4 weeks"
	ExpiresByType video/webm "access plus 4 weeks"
	ExpiresByType video/x-flv "access plus 4 weeks"
	ExpiresByType application/javascript "access plus 4 weeks"
	ExpiresByType application/json "access plus 0 seconds"
	ExpiresByType application/xml "access plus 0 seconds"
	ExpiresByType application/x-shockwave-flash "access plus 4 weeks"
	ExpiresByType application/vnd.ms-fontobject "access plus 4 weeks"
	ExpiresByType application/x-font-ttf "access plus 4 weeks"
	ExpiresByType application/font-woff "access plus 4 weeks"
	ExpiresByType application/font-woff2 "access plus 4 weeks"
	ExpiresByType font/opentype "access plus 4 weeks"
</IfModule>
```

compress text file response
```php
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/json
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

## redirects

Enable Url rewriting
```php
RewriteEngine On
```

redirect HTTP requests to HTTPS
```php
RewriteCond %{HTTPS} off
RewriteCond %{HTTP_HOST} !=localhost
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

Optional redirect every URL to www
```php
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} !=localhost
RewriteRule ^ http://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

pass the Authorization header to PHP
```php
SetEnvIf Authorization "(.+)" HTTP_AUTHORIZATION=$1
```
this is also possible with a redirect rule
```php
RewriteCond %{HTTP:Authorization} .
RewriteRule ^ - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
```

Run everything but real files through index.php
```php
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php?/$1 [L]
```

you can also redirect all requests through index.php, expect a specific Forder for public resources 
```php
# if folder not "public", then rewrite to index.php
RewriteRule !^(public)/(.*)$ index.php [NC,L]
```

## security

set headers for unknown content types
```php
<IfModule mod_headers.c>
    # serve files as plain text if the actual content type is not known
    # (hardens against attacks from malicious file uploads)
    Header set Content-Type "text/plain" "expr=-z %{CONTENT_TYPE}"
    Header set X-Content-Type-Options "nosniff"
</IfModule>
```

Prevent file browsing and disable the "MultiViews" option
```php
<IfModule mod_negotiation.c>
    Options -MultiViews
	Options -Indexes
</IfModule>
```

Block direct access for filters and specific files.
These lines should be placed under the line, on you pass the request to php files.
(Thenty only be observed in case these files are accessible)

```php
# Block all direct access for these folders
RewriteRule ^(\.git|cache|bin|logs|backup|webserver-configs|tests)/(.*) error [F]
# Block access to specific file types for these system folders
RewriteRule ^(system|vendor)/(.*)\.(txt|xml|md|html|json|yaml|yml|php|pl|py|cgi|twig|sh|bat)$ error [F]
# Block all direct access to files and folders beginning with a dot
# except for the .well-known folder, which is used for Let's Encrypt and security.txt
RewriteRule (^|/)\.(?!well-known) - [F]
# Block access to specific files in the root folder
RewriteRule ^(LICENSE\.txt|composer\.lock|composer\.json|\.htaccess)$ error [F]
```

disable frame integration of the website in other sites
```php
<IfModule mod_headers.c>
    Header append X-Frame-Options SAMEORIGIN
</IfModule>
```

prevent svg xss attacks
```php
<IfModule mod_headers.c>
    <FilesMatch "\.(?i:svg)$">
        Header set Content-Security-Policy "script-src 'none'"
    </FilesMatch>
</IfModule>
```

## source

- https://github.com/getkirby/starterkit
- https://github.com/getgrav/grav
- https://github.com/shopware5/shopware/blob/5.7/.htaccess.dist
- https://help.creoline.com/doc/svg-xss-protection-mp3mMJd4IU
- https://stackoverflow.com/questions/21417263/htaccess-add-remove-trailing-slash-from-url