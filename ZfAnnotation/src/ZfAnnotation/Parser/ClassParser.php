<?php
namespace ZfAnnotation\Parser;

use Exception;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Scanner\ClassScanner;
use Zend\EventManager\EventManager;
use ZfAnnotation\Config\Collection;
use ZfAnnotation\Event\ParseEvent;

class ClassParser
{
    /**
     * @var AnnotationManager
     */
    protected $annotationManager;
    
    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var array
     */
    protected $classes;

    /**
     * @var Collection
     */
    protected $configCollection = array();
    
    /**
     * 
     * @param array $classes
     * @param \Zend\Code\Annotation\AnnotationManager $annotationManager
     * @param \Zend\EventManager\EventManager $eventManager
     * @param \ZfAnnotation\Config\Collection $configCollection
     */
    public function __construct(array $classes, AnnotationManager $annotationManager, EventManager $eventManager, Collection $configCollection)
    {
        $this->classes = $classes;
        $this->configCollection = $configCollection;
        $this->annotationManager = $annotationManager;
        $this->eventManager = $eventManager;
    }

    /**
     * @return array
     */
    public function parse()
    {
        $this->eventManager->trigger(new ParseEvent(ParseEvent::EVENT_BEGIN,  $this->configCollection));
        
        /* @var $class ClassScanner */
        foreach ($this->classes as $class) {
            $this->parseClass($class);
        }
        $this->eventManager->trigger(new ParseEvent(ParseEvent::EVENT_FINISH,  $this->configCollection));
        return $this->configCollection->getConfig();
    }

    /**
     * @param ClassScanner $class
     */
    public function parseClass(ClassScanner $class)
    {
        $classAnnotations = $class->getAnnotations($this->annotationManager);
        if ($classAnnotations instanceof AnnotationCollection) {
            foreach ($classAnnotations as $annotation) {
                $this->eventManager->trigger(new ParseEvent(ParseEvent::EVENT_CLASS_ANNOTATION,  $annotation, array(
                    'class' => $class,
                    'configs' => $this->configCollection
                )));
            }
        } else {
            $classAnnotations = new AnnotationCollection(array());
        }
        
        foreach ($class->getMethods() as $method) {
            // zf can't process abstract methods for now, wrap with "try" block
            try {
                $methodAnnotations = $method->getAnnotations($this->annotationManager);
                if ($methodAnnotations instanceof AnnotationCollection) {
                    foreach ($methodAnnotations as $annotation) {
                        $this->eventManager->trigger(new ParseEvent(ParseEvent::EVENT_METHOD_ANNOTATION,  $annotation, array(
                            'class' => $class,
                            'method' => $method,
                            'class_annotations' => $classAnnotations,
                            'configs' => $this->configCollection
                        )));
                    }
                }
            } catch (Exception $skip) {}
        }
    }
}