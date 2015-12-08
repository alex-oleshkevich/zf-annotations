## Custom annotations
This module operates with 2 main concepts: Annotation and EventListener.  
In order to add support of custom annotation you have to implement annotation class and its listener.

#### Annotation class
This class must implement `Zend\Code\Annotation\AnnotationInterface` and contain public properties which are used as annotation options:

```php
class MyAnnotation implements Zend\Code\Annotation\AnnotationInterface
{
    public $option1;
    public $optionsArray = array();
    // ...
}
```
Then add it to class or class member in docblock:
```php
/**
* @MyAnnotation(option="name", optionsArray={"value1", "value2"})
*/
```
Note, if your annotation provides a service (managed by service locator) you don't need to do much, just extend it from `ZfAnnotation\Annotation\Service` and override `$serviceManager` property with the name of your custom service manager.
```php
class MyServiceAnnotation extends ZfAnnotation\Annotation\Service
{
    public $serviceManager = 'my_service_manager';
    public $option1;
    public $optionsArray = array();
    // ...
}
```
use as:
```php
/**
* @MyServiceAnnotation(
*     name="my_service_annotation', 
*     type="abstractFactory", 
*     option="name", 
*     optionsArray={"value1", "value2"}
* )
*/
```

#### Event listener class
This class must extend `Zend\EventManager\AbstractListenerAggregate` and must subscribe to `ParseEvent::EVENT_CLASS_PARSED` event:
```php
class MyListener extends Zend\EventManager\AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }
    
    public function onClassParsed(ParseEvent $event)
    {
    
    }
```
A `onClassParsed` callback receives event which includes:
```php 
// this class keeps track about all class and member annotations
ZfAnnotation\Parser\ClassAnnotationHolder $holder = $event->getTarget();

// application config
array $config = $event->getParam('config');
```

Sample listener listing used in my projects:
```php
/**
* This listener iterates over class and method annotations of type Assert 
* gets class and method names and populates "config" array.
*/
class AnnotationListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }
    
    public function onClassParsed(ParseEvent $event)
    {
        $classHolder = $event->getTarget();
        $methodHolders = $classHolder->getMethods();
        $config = $event->getParam('config');
        foreach ($methodHolders as $methodHolder) {
            foreach ($methodHolder->getAnnotations() as $annotation) {
                if ($annotation instanceof Assert) { // Assert - is an annotation
                    $controller = $classHolder->getClass()->getName(); // name of class containing this annotation
                    $method = $methodHolder->getMethod()->getName(); // name of method containing this annotation
                    $config['asserts'][$controller][$method][] = $annotation->getName();
                }
            }
        }
        // merge new config into old one and set it as listener result
        // this is important if you want to have access to the data collected in this function.
        $event->mergeResult($config);
    }
}

```

#### Register your annotation and listener in application config
```php
// somewhere in app/module.config.php
return array(
    'zf_annotation' => array(
        'annotations' => array(
            'MyAnnotation'
        ),
        'event_listeners' => array(
            'MyEventListener'
        )
    )
```