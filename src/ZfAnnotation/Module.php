<?php

/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation;

use Exception;
use Traversable;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceManager;
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
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array( $this, 'onLoadModules' ), 1000);
    }

    /**
     * @param ModuleEvent $event
     * @throws Exception
     */
    public function onLoadModules(ModuleEvent $event)
    {
        /* @var $serviceManager ServiceManager */
        $serviceManager = $event->getParam('ServiceManager');
        $appConfig = $event->getConfigListener()->getMergedConfig(false);
        $config = array();

        // check if should rescan files on every request
        if ($appConfig['zf_annotation']['compile_on_request']) {
            $config = ClassParserFactory::factory($appConfig, $serviceManager)->parse();
        } else {
            // if scanner disable check if we have to load config from cache
            if ($appConfig['zf_annotation']['use_cache']) {
                // load if file exists
                if (file_exists($appConfig['zf_annotation']['cache_file'])) {
                    $config = include $appConfig['zf_annotation']['cache_file'];
                } else {
                    throw new Exception('Cache file: ' . $appConfig['zf_annotation']['cache_file'] . 'does not exists.');
                }
            }
        }

        $event->getConfigListener()->setMergedConfig(ArrayUtils::merge($appConfig, $config));
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
