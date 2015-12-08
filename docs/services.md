## Service annotations

This component is completely compatible with standard ZF2 service manager and its variants.  
Included ServiceManager-based annotations:
* Service
* Controller
* ControllerPlugin
* Filter
* FormElement
* Hydrator
* InputFilter
* LogProcessor
* LogWriter
* RoutePlugin
* Serializer
* Service
* Validator
* ViewHelper

### Usage

#### Import appropriate service annotation
```php
use ZfAnnotation\Annotation\Service;
// or ZfAnnotation\Annotation\Controller;
// or ZfAnnotation\Annotation\ViewHelper;
// ...
```

#### Annotate class with selected annotation
```php
/**
 * @Service
 */
class MyService
{

}
```
A generated output will be:
```php
array (
    'service_manager' => array(
        'invokables' => array(
            'MyService'  => 'MyService'
        )
    )
);
```
This annotation is flexible in its configuration. You can modify it by adding "name",  "type", "shared", "aliases", "service_manager" options.
```php
/**
 * @Service(
 *      name="my_view_helper", 
 *      type="factory", 
 *      shared=false, 
 *      aliases={"mvh", "superhelper"}, 
 *      service_manager="view_helpers"
 * )
 */
class MyCustomerViewHelper implements FactoryInterface
{

}
```
The result of the annotation above will be:
```php
array(
    'view_helpers' => array(
        'factories' => array(
            'my_view_helper' => 'MyCustomerViewHelper'
        ),
        'shared' => array(
            'my_view_helper' => false
        ),
        'aliases' => array(
            'my_view_helper' => array(
                'mvh' => 'my_view_helper',
                'superhelper' => 'my_view_helper'
            )
        )
    )
)
```
As this module ships annotations for all build-in services in ZF2 you can rewrite the code above and make it use `ViewHelper` annotation:
```php
/**
 * @ViewHelper(
 *      name="my_view_helper", 
 *      type="factory", 
 *      shared=false, 
 *      aliases={"mvh", "superhelper"}
  * )
 */
class MyCustomerViewHelper implements FactoryInterface
{

}
```
The output is as same as returned by previous example.
