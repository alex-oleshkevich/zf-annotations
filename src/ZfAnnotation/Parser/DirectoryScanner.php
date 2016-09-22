<?php

/**
 * Annotation module for Zend Framework 2.
 *
 * @link      https://github.com/alex-oleshkevich/zf-annotations the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ZfAnnotation\Parser;

use ClassNames\ClassNames;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

/**
 * Contains class definition and its annotations.
 */
class DirectoryScanner
{

    /**
     * 
     * @param string $directory
     * @return string[]
     */
    public function scan($directory)
    {
        $directoryIterator = new RecursiveDirectoryIterator($directory);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator);
        $iterator = new RegexIterator($recursiveIterator, '/^.+\.php$/i');

        /* @var $file SplFileInfo */
        foreach ($iterator as $file) {
            $scanner = new ClassNames;
            $classes = $scanner->getClassNames($file->getPathname());
            foreach ($classes as $class) {
                yield $class;
            }
        }
    }

}
