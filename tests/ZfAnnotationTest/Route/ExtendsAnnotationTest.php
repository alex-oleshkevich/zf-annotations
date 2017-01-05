<?php

namespace ZfAnnotationTest\Route;

use ZfAnnotation\EventListener\RouteListener;
use ZfAnnotationTest\AnnotationTestCase;
use ZfAnnotationTest\Route\TestAsset\ExtendsController;
use ZfAnnotationTest\Route\TestAsset\TreeExtends\BackendController;
use ZfAnnotationTest\Route\TestAsset\TreeExtends\DownloadController;
use ZfAnnotationTest\Route\TestAsset\TreeExtends\ImageController;

/**
 * @group zfa-router
 * @group zfa-router-extends
 */
class ExtendsAnnotationTest extends AnnotationTestCase
{

    protected function setUp()
    {
        $this->listener = new RouteListener;
    }

    public function testIndexRouteCorrected()
    {
        $routeConfig = [
            'default' => [
                'type' => 'literal',
                'priority' => 0,
                'options' => [
                    'route' => '/'
                ],
                'child_routes' => [
                    'help' => [
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => [
                            'route' => '/help'
                        ],
                    ]
                ]
            ]
        ];

        $config = array_replace_recursive($this->parse(ExtendsController::class)['router']['routes'], $routeConfig);

        $expected = [
            'default' => [
                'type' => 'literal',
                'priority' => 0,
                'options' => [
                    'route' => '/'
                ],
                'child_routes' => [
                    'help' => [
                        'type' => 'literal',
                        'priority' => 0,
                        'options' => [
                            'route' => '/help'
                        ],
                        'child_routes' => [
                            'root' => [
                                'type' => 'literal',
                                'priority' => 0,
                                'options' => [
                                    'route' => '/root',
                                    'defaults' => [
                                        'controller' => ExtendsController::class,
                                        'action' => 'index'
                                    ],
                                    'constraints' => null
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'index' => [
                                        'type' => 'literal',
                                        'priority' => 0,
                                        'options' => [
                                            'route' => '/index',
                                            'defaults' => [
                                                'controller' => ExtendsController::class,
                                                'action' => 'index'
                                            ],
                                            'constraints' => null
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => []
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
            ]
        ];

        $this->assertEquals($expected, $config);
    }

    /**
     * @group tree-parsed
     */
    public function testTreeParsed()
    {
        $expected = [
            'router' => [
                'routes' => [
                    'backend' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/dashboard',
                            'defaults' => [
                                'controller' => 'ZfAnnotationTest\\Route\\TestAsset\\TreeExtends\\BackendController',
                                'action' => 'index',
                            ],
                            'constraints' => NULL,
                        ],
                        'priority' => 0,
                        'may_terminate' => true,
                        'child_routes' => [
                            'downloads' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/downloads',
                                    'defaults' => [
                                        'controller' => 'ZfAnnotationTest\\Route\\TestAsset\\TreeExtends\\DownloadController',
                                        'action' => 'index',
                                    ],
                                    'constraints' => NULL,
                                ],
                                'priority' => 0,
                                'may_terminate' => true,
                                'child_routes' => [
                                    'image' => [
                                        'type' => 'literal',
                                        'options' => [
                                            'route' => '/image',
                                            'defaults' => [
                                                'controller' => 'ZfAnnotationTest\\Route\\TestAsset\\TreeExtends\\ImageController',
                                                'action' => 'index',
                                            ],
                                            'constraints' => NULL,
                                        ],
                                        'priority' => 0,
                                        'may_terminate' => true,
                                        'child_routes' => [
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];


        $parser = $this->createParser();
        $parser->attach(new RouteListener);

        $config = $parser->parse([
            BackendController::class,
            DownloadController::class,
            ImageController::class
        ]);

        $this->assertEquals($expected, $config);
    }

}
