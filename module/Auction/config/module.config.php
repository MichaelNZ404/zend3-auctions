<?php
namespace Auction;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'auction' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/auction[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuctionController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'auction' => __DIR__ . '/../view',
        ],
    ],
];