## Config annotations for Zend Framework 2

This module allow to define controllers, services, routes and other ZF components via annotations.
The goal of this project is to get rid of large routes configuration arrays in module configs.

***please note, the module is not well tested yet***

![Build Status](https://travis-ci.org/alex-oleshkevich/zf-annotations.svg)
[![Latest Stable Version](https://poser.pugx.org/alex-oleshkevich/zf-annotations/v/stable.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations) [![Total Downloads](https://poser.pugx.org/alex-oleshkevich/zf-annotations/downloads.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations) [![Latest Unstable Version](https://poser.pugx.org/alex-oleshkevich/zf-annotations/v/unstable.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations) [![License](https://poser.pugx.org/alex-oleshkevich/zf-annotations/license.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations)
![Deps. Status](https://www.versioneye.com/user/projects/54d47c133ca08495310002b0/badge.svg?style=flat)

### Requirements
* PHP >= 5.4.0

### Installation
##### Require via composer

```bash
composer require alex-oleshkevich/zf-annotations
```

##### Enable it in application.config.php
```php
return array(
    'modules' => array(
        // other modules
        'ZfAnnotation'
    ),
    // other content
);
```

##### Configure:
```php
array(
    'zf_annotation' => array(
        // directories where to look for files (eg. __DIR__ . '/../../module)
        'directories' => array(),
                             
        // parse controllers on every request. disable on prod
        'compile_on_request' => false,
        
        // use cached routes instead of controllers parsing, enable on prod
        'use_cache' => false,
        
        // a file to dump router config
        'cache_file' => 'data/cache/annotated-config.cache.php'
    ),
)
```

### Components

 * [Router](https://github.com/alex-oleshkevich/zf-annotations/tree/master/docs/router.md)

### Command line usage:
```bash
# Compile and dump routes to cache file
php public/index.php cache dump
```