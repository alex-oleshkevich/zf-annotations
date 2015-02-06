## Config annotations for Zend Framework 2

This module allow to define controllers, services, routes and other ZF components via annotations.
The goal of this project is to get rid of large routes configuration arrays in module configs.

**please note, the module is not well tested yet**

#### Install module via composer
```bash
composer require alex-oleshkevich/zf-annotations
```

#### Enable it in application.config.php
```php
return array(
    'modules' => array(
        // other modules
        'ZfAnnotation'
    ),
    // other content
);
```

#### Components

 * [Router](https://github.com/alex-oleshkevich/zf-annotations/tree/master/docs/router.md)

#### Command line usage:
```bash
# Compile and dump routes to cache file
php public/index.php cache dump
```