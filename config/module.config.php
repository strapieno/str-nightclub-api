<?php

return [
    'router' => [
        'routes' => [
            'api-rest' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/rest'
                ],
                'child_routes' => [
                    'user' => [
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => [
                            'route' => '/user[/:user_id]',
                            'defaults' => [
                                'controller' => 'Strapieno\NightClub\Api\V1\Rest\Controller'
                            ],
                            'constraints' => [
                                'user_id' => '[0-9a-f]{24}'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'matryoshka-apigility' => [
        'matryoshka-connected' => [
                'Strapieno\NightClub\Api\V1\Rest\ConnectedResource' => [
                'model' => 'Strapieno\NightClub\Model\NightClubModelService',
                'collection_criteria' => 'Strapieno\NightClub\Model\Criteria\NightClubCollectionCriteria',
                'entity_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria'
            ]
        ]
    ],
    'zf-rest' => [
        'Strapieno\NightClub\Api\V1\Rest\Controller' => [
            'service_name' => 'user',
            'listener' => 'Strapieno\NightClub\Api\V1\Rest\ConnectedResource',
            'route_name' => 'api-rest/user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'users',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                'user_name',
                'email',
                'first_name',
                'last_name',
                'order_by',
            ],
            'page_size' => 10,
            'page_size_param' => 'page_size',
            'collection_class' => 'Zend\Paginator\Paginator', // FIXME function?
        ]
    ],
    'zf-content-negotiation' => [
        'accept_whitelist' => [
            'Strapieno\NightClub\Api\V1\Rest\Controller' => [
                'application/hal+json',
                'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Strapieno\NightClub\Api\V1\Rest\Controller' => [
                'application/json'
            ],
        ],
    ],
     'zf-hal' => [
        // map each class (by name) to their metadata mappings
        'metadata_map' => [
            'Strapieno\NightClub\Model\Entity\NightClubEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'NightClubApiHydrator',
            ],
        ],
    ],
    'zf-content-validation' => [
    ]
];
