<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation;

use Exception;
use ReflectionClass;
use Traversable;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Stdlib\ArrayUtils;
use ZfAnnotation\Service\ClassParserFactory;

class Module implements AutoloaderProviderInterface, InitProviderInterface, ConfigProviderInterface
{

    /**
     * @param ModuleManagerInterface $moduleManager
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_MERGE_CONFIG, array($this, 'onMergeConfig'));
    }

    /**
     * @param ModuleEvent $event
     * @throws Exception
     */
    public function onMergeConfig(ModuleEvent $event)
    {
        // do not parse annotations if config cache is enabled.
        $config = $event->getConfigListener()->getMergedConfig(false);

        $parser = ClassParserFactory::factory($config, $event->getTarget()->getEventManager());
        $modules = $event->getTarget()->getLoadedModules();
        $modulesAllowedToScan = $config['zf_annotation']['scan_modules'];
        foreach ($modules as $module) {
            $parts = explode('\\', get_class($module));
            $modName = array_shift($parts);
            if (!empty($modulesAllowedToScan) && !in_array($modName, $modulesAllowedToScan)) {
                continue;
            }

            $ref = new ReflectionClass($module);
            $dir = dirname($ref->getFileName());

            $classes = new DirectoryScanner($dir);
            $parsedConfig = $parser->parse($classes->getClasses());
        }
        $event->getConfigListener()->setMergedConfig(array_replace_recursive($parsedConfig, $config));
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getConsoleUsage()
    {
        return array(
            'config dump' => 'Compiles config and dump into cache file.',
        );
    }

}
