<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        // Map middleware -> factories here
        'factories' => [
        ],
    ],

    'routes' => [
        // Example:
         [
             'name' => 'home',
             'path' => '/',
             'middleware' => App\Action\Home::class,
             'allowed_methods' => ['GET'],
         ],
    ],
];
