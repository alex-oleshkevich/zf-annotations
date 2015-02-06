## Config annotations for Zend Framework 2

This module allow to define controllers, services, routes and other ZF components via annotations.
The goal of this project is to get rid of large routes configuration arrays in module configs.

***please note, the module is not well tested yet***

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