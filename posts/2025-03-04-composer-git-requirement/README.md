---
title: 'require git repos with composer'
taxonomy:
    tag:
        - GIT
        - PHP
date: '2025-03-04'
---

As a PHP developer, you will certainly also love composer to manage dependencies.

Sometimes I need another repo in a project. There is an easy way to use other repos without a registration of them on Packagist. 

The repository you need in another project have to have a ```composer.json``` file.
In this file is the 'name' attribute is required, all other is optional and depends on the need of the code in this repository. 

```json
{
    "name": "falkm/proxy",
    "autoload": {
        "psr-4": {
            "FalkM\\Proxy\\": "src"
        }
    }
}
```

In the project how you need the dependency, insert a "repositories" list and then require package by name: 

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/falk-m/proxy"
      }
    ],
    "require": {
     "falkm/proxy": "dev-master"
    }
}
```

You can also use semantic versioning in the package repository.
That means tags like '1.0.0'.
Then you can require them by tag: ```"falkm/proxy": "1.*"```

