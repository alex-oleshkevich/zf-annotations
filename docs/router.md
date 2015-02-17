## Annotated Router for Zend Framework 2

This module allows usage of annotations in controller's comment blocks to define routes.
The goal of this project is to get rid of large routes configuration arrays in module configs.

This module is completely compatible with standard ZF2 router as it generates the same config as defined within module.

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

#### Default configuration:
Default options can be overwritted within your application:
```php
array(
    'annotated_router' => array(
        // if true, parser will rescan and parse controller on every page request
        'compile_on_request' => true, 
        // cache file
        'cache_file' => 'data/cache/router.cache.php', 
        // if true and 'compile_on_request' is off, will load config from 'cache_file'
        'use_cache' => true,  
    ),
)
```

#### Command line usage:
```bash
# Compile and dump routes to cache file
cli router dump           

# Compile and dump all routes including defined in module.config.php
cli router dump --complete
```

#### Add annotations namespace
```php
use ZfAnnotation\Annotation\Route;
```

#### Annotate actions\class with @Route annotation
```php
/**
 * @Route(name="dashboard", route="/dashboard")
 */
public function indexAction()
{
    return new ViewModel();
}
```
A generated output will be:
```php
array (
    'dashboard' => array(
        'type' => 'literal',
        'options' => array(
            'route' => '/dashboard'
        ),
    )
);
```

#### If you want to group actions under the same parent route, add @Route annotation to class definition:
```php
/**
 * @Route(name="home", route="/")
 */
class IndexController extends AbstractActionController
```
This will result in:
```php
array (
    'home' => array(
        'type' => 'literal',
        'options' => array(
            'route' => '/'
        ),
        'child_routes' => array(
            'dashboard' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/dashboard'
                ),
            )
        )
    )
);
```

#### Class-level annotations can be merged into another route:
```php
/**
 * @Route(extends="parent/route", name="home", route="/")
 */
class IndexController extends AbstractActionController
```

Array:
```php
array (
    'parent' => array(
        'type' => 'literal',
        'options' => array(
            'route' => '/parent'
        ),
        'child_routes' => array(
            'route' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/route'
                ),
                'child_routes' => array(
                    'home' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/home'
                        ),
                    ),
                    'child_routes' => array(
                        // routes from /home route controller actions
                    )
                )
            )
        )
    )
);
```


### Important to know
#### Complete @Route definition
```php
/**
 * @Route(
 *     extends="parent-route"
 *     name="complete-definition",
 *     route="/complete-definition/:id/:method",
 *     type="segment",
 *     defaults={"controller": "nobase", "action": "complete-definition-action"},
 *     constraints={"id": "\d+", "method": "\w+"},
 *     mayTerminate: true
 * )
 */
public function someAction() {}
// or if apply to controller
class IndexController extends AbstractActionController
```

1. "extends" only applied to class-level route definition, if you try to add it to action route, that will fail with exception as it is not currently implemented.
2. "extends" must contain valid and existing route;
3. "extends" can point to child route, eg. passing {"extends": "root/first/second"} will extend given path with routes from current class;
4. Root route annotation must contain "route" and "name";
5. Child (action) routes may be empty (see full controller listing). In that case module will try to guess options;
5. Config, defined in module.config.php has the higher priority than annotations. If there are 2 routes with the same name defined via @Route and via module.config.php, the last one will be passed to router..

#### Complete controller listing:
```php
<?php
namespace ZfAnnotationTest\TestController;

use ZfAnnotation\Annotation\Route;
use Zend\Mvc\Controller\AbstractActionController;

/**
* @Route(
*     extends="other/route",
*     name="root-route",
*     route="/path/to/web/page/id/:id/:method",
*     type="segment",
*     defaults={"controller": "my-controller", "action": "my-action"},
*     constraints={"id": "\d+", "method": "\w+"}
* )
*/
class IndexController extends AbstractActionController
{
    /**
     * @Route(
     *     name="index",
     *     route="/index/:id/:method",
     *     type="segment",
     *     priority=1000,
     *     defaults={"controller": "my-controller", "action": "my-action"},
     *     constraints={"id": "\d+", "method": "\w+"}
     * )
     */
    public function action1Action()
    {}

    /**
     * @Route(
     *     route="/route",
     *     type="literal",
     *     defaults={"controller": "my-controller", "action": "my-action"}
     * )
     */
    public function action2Action()
    {}

    /**
     * @Route(
     *     type="literal",
     *     defaults={"controller": "my-controller", "action": "my-action"}
     * )
     */
    public function action3Action()
    {}

    /**
     * @Route(
     *     defaults={"controller": "my-controller", "action": "my-action"}
     * )
     */
    public function action4Action()
    {}

    /**
     * @Route(
     *     defaults={"action": "my-action"}
     * )
     */
    public function action5Action()
    {}

    /**
     * @Route
     */
    public function action6Action()
    {}
}

```


