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
                    'nightclub' => [
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => [
                            'route' => '/nightclub[/:nightclub_id]',
                            'defaults' => [
                                'controller' => 'Strapieno\NightClub\Api\V1\Rest\Controller'
                            ],
                            'constraints' => [
                                'nightclub_id' => '[0-9a-f]{24}'
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
                    'prototype_strategy' => 'Matryoshka\Model\Object\PrototypeStrategy\ServiceLocatorStrategy',
                    'collection_criteria' => 'Strapieno\NightClub\Model\Criteria\NightClubCollectionCriteria',
                    'entity_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria',
                    'hydrator' => 'NightClubApiHydrator'
            ]
        ]
    ],
    'zf-rest' => [
        'Strapieno\NightClub\Api\V1\Rest\Controller' => [
            'service_name' => 'nightclub',
            'listener' => 'Strapieno\NightClub\Api\V1\Rest\ConnectedResource',
            'route_name' => 'api-rest/nightclub',
            'route_identifier_name' => 'nightclub_id',
            'collection_name' => 'nightclubs',
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
                'route_name' => 'api-rest/nightclub',
                'route_identifier_name' => 'nightclub_id',
                'hydrator' => 'NightClubApiHydrator',
            ],
            'Strapieno\NightClub\Model\Entity\ClubPriveEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/nightclub',
                'route_identifier_name' => 'nightclub_id',
                'hydrator' => 'NightClubApiHydrator',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Strapieno\NightClub\Api\V1\Rest\Controller' => [
            'input_filter' => 'Strapieno\NightClub\Model\InputFilter\DefaultInputFilter',
            'POST' => 'Strapieno\NightClub\Api\InputFilter\PostInputFilter'
        ]
    ],
    'strapieno_input_filter_specs' => [
        'Strapieno\NightClub\Api\InputFilter\PostGeoCoordiateInputFilter' => [
            'latitude' => [
                'name' => 'latitude',
                'require' => true,
                'allow_empty' => false
            ],
            'longitude' => [
                'name' => 'longitude',
                'require' => true,
                'allow_empty' => false
            ]
        ],
        'Strapieno\NightClub\Api\InputFilter\PostPostalAddressInputFilter' => [
            'address_locality' => [
                'name' => 'address_locality',
                'require' => true,
                'allow_empty' => false
            ],
            'address_region' => [
                'name' => 'address_region',
                'require' => true,
                'allow_empty' => false
            ],

            'postal_code' => [
                'name' => 'postal_code',
                'require' => true,
                'allow_empty' => false
            ],

            'street_address' => [
                'name' => 'street_address',
                'require' => true,
                'allow_empty' => false
            ],

            'address_country' => [
                'name' => 'address_country',
                'require' => true,
                'allow_empty' => false
            ],
        ],

        'Strapieno\NightClub\Api\InputFilter\PostInputFilter' => [
            'merge' => 'Strapieno\NightClub\Model\InputFilter\DefaultInputFilter',
            'name' => [
                'name' => 'name',
                'require' => true,
                'allow_empty' => false
            ],
            'type' => [
                'name' => 'type',
                'require' => true,
                'allow_empty' => false
            ],
            'geo_coordinate' => [
                'name' => 'geo_coordinate',
                'type' => 'Strapieno\NightClub\Api\InputFilter\PostGeoCoordiateInputFilter'

            ],
            'postal_address' => [
                'name' => 'postal_address',
                'type' => 'Strapieno\NightClub\Api\InputFilter\PostPostalAddressInputFilter'
            ],
        ],
    ]
];
