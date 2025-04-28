<?php

use Kirby\Cms\App as Kirby;
use Kirby\Cms\Response;

require_once(implode(DIRECTORY_SEPARATOR, [__DIR__, "vendor", "autoload.php"]));

Kirby::plugin('sunds/upload', [
    "api" => [
        /* protected routes. Call from vue components with this.$api.get(`example/plugin/test`)*/
        "routes" => [
            [
                'pattern' => 'example/plugin/(:all)',
                'method' => 'GET|POST',
                'action' => function ($slug) {
                    return [
                        "slug" => " Hello {$slug}"
                    ];
                },
            ]
        ]
    ],
    /*public routes*/
    "routes" => [
        [
            'pattern' => 'example/plugin/(:all)',
            'method' => 'GET|POST',
            'action' => function ($slug) {
                return Response::json([
                    "slug" => $slug
                ]);
            },
        ]
    ],
    'fields' => [
        'example-field' => [
            'props' => [
                'sameValue' => function () {
                    return "blub";
                }
            ]
        ]
    ],
    /*panel areas*/
    'areas' => [
        "example-area" => [
            'label' => 'Tags',
            'icon' => 'tag',
            'breadcrumbLabel' => function () {
                return 'Tags';
            },
            'menu' => true,
            'link' => 'tags',
            'views' => [
                [
                    'pattern' => 'tags',
                    'action'  => function () {
                        return [
                            'component' => 'example-view',
                            'title' => 'Tags',
                            'props' => [
                                'tags' => [
                                    [
                                        'key' => 'test',
                                        'title' => 'Test'
                                    ]
                                ]
                            ],
                        ];
                    }
                ]
            ]
        ]
    ],
]);
