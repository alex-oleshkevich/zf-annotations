<?php
/**
 * Annotated Router module for Zend Framework 2
 *
 * @link      https://github.com/alex-oleshkevich/zf2-annotated-routerfor the canonical source repository
 * @copyright Copyright (c) 2014 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Controller;

use Zend\Code\Generator\ValueGenerator;
use Zend\Console\Console;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controller for command-line rool
 */
class ConsoleController extends AbstractActionController
{
    /**
     * Dumps calculated routes into cache file.
     * @see annotated_router.cache_file config key
     */
    public function dumpAction()
    {
        $config = $this->serviceLocator->get('Config');
        $console = Console::getInstance();
        $console->writeLine('Dumping annotated routes into "' . $config['zf_annotation']['cache_file'] . '"');
        $parser = \ZfAnnotation\Service\ClassParserFactory::factory($config, $this->serviceLocator);
        $annotatedConfig = $parser->parse();

        $generator = new ValueGenerator($annotatedConfig);
        $content = "<?php\n\nreturn " . $generator . ';';

        file_put_contents($config['zf_annotation']['cache_file'], $content);
    }
}