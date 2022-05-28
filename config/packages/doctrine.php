<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $config = [
        'dbal' => [
            'url' => '%env(resolve:DATABASE_URL)%',
        ],
        'orm' => [
            'auto_generate_proxy_classes' => true,
            'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
            'auto_mapping' => true,
        ],
    ];

    if ('prod' === $container->env()) {
        $config['orm']['auto_generate_proxy_classes'] = false;
        $config['orm']['query_cache_driver'] = [
            'type' => 'pool',
            'pool' => 'doctrine.system_cache_pool',
        ];
        $config['orm']['result_cache_driver'] = [
            'type' => 'pool',
            'pool' => 'doctrine.result_cache_pool',
        ];

        $container->extension('framework', [
            'cache' => [
                'pools' => [
                    'doctrine.result_cache_pool' => [
                        'adapter' => 'cache.app',
                    ],
                    'doctrine.system_cache_pool' => [
                        'adapter' => 'cache.system',
                    ],
                ],
            ],
        ]);
    }

    if ('test' === $container->env()) {
        $config['dbal']['dbname_suffix'] = '_test%env(default::TEST_TOKEN)%';
    }

    $container->extension('doctrine', $config);
};
