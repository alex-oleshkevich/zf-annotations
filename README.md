## Annotations for Zend Framework.

This module provides "configuration via annotation" support for Zend Framework.
Out of the box it allows to define routes, service and all the ServiceManager-based implementations (as controllers, view helpers, etc).  
The goal of this project is to get rid of large configuration arrays in application configs.

![Build Status](https://travis-ci.org/alex-oleshkevich/zf-annotations.svg)
[![Latest Stable Version](https://poser.pugx.org/alex-oleshkevich/zf-annotations/v/stable.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations) 
[![Monthly Downloads](https://poser.pugx.org/alex-oleshkevich/zf-annotations/d/monthly)](https://packagist.org/packages/alex-oleshkevich/zf-annotations)
[![Total Downloads](https://poser.pugx.org/alex-oleshkevich/zf-annotations/downloads)](https://packagist.org/packages/alex-oleshkevich/zf-annotations)
[![Latest Unstable Version](https://poser.pugx.org/alex-oleshkevich/zf-annotations/v/unstable.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations) 
[![License](https://poser.pugx.org/alex-oleshkevich/zf-annotations/license.svg)](https://packagist.org/packages/alex-oleshkevich/zf-annotations)
![Deps. Status](https://www.versioneye.com/user/projects/54d47c133ca08495310002b0/badge.svg?style=flat)

### Requirements
* PHP >= 5.5.0

### Please, note
1. if you want to use Zend libraries from Zend Framework 2, use ~1.0 versions. Branch ~2.0 supports future versions of Zend Framework and may not be compatible with ZF 2.

2. Since version 2.3 the module does not uses [zendframework/zend-code](https://github.com/zendframework/zend-code) as a backend and uses [doctrine/annotations](https://github.com/doctrine/annotations) directly. See [doctrine documentation](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html) for more details and options.

### Deprecations
1. Config option "annotations" deprecated in favor of "namespaces".

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

#### Configuration:
```php
array(
    'zf_annotation' => array(
        // in which modules to search annotated classes
        'scan_modules' => array(),

        // DEPRECATED!                             
        // here listed all annotations supported by the module
        // add your own here
        'annotations' => array(
            'ZfAnnotation\Annotation\Route',
            // ...
        ),
        
        /*
         * IMPORTANT NOTE:
         * The given directories should NOT be the directory where classes of the namespace are in, 
         * but the base directory of the root namespace. The AnnotationRegistry uses a namespace to directory separator
         * approach to resolve the correct path.
         */
        'namespaces' => array(
            'My\Annotation' => '/path/to/annotations'
        ),
        
        // listeners to events emitted by parser. 
        // they process class annotations and transforms them into config values
        // add your own here.
        'event_listeners' => array(
            'ZfAnnotation\EventListener\RouteListener',
            // ...
        ),
        // if not null, supplied directory would used for cache to speed up parsing
        'cache' => '/path/to/cache/dir',
        // if true, will ignore cached data and always return a fresh one.
        'cache_debug' => false
    )
)
```

### Components
 * [Router](docs/router.md)
 * [Services](docs/services.md)

### Read how to add own annotations
* [Custom annotations](docs/custom-annotations.md)

### Performance
This module is pretty fast, but anyway, parsing of lots of files on each request takes time.  
The module subscribes to `ModuleEvent::EVENT_MERGE_CONFIG` and scans every time its is triggered.  If you have option 
`module_listener_options.config_cache_enabled` enabled, annotation parser will not do parsing unless you set `config_cache_enabled` to false or remove a cache file. [More info about caching here](https://akrabat.com/caching-your-zf2-merged-configuration/).
