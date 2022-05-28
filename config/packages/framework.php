<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $config = [
        'secret' => '%env(APP_SECRET)%',
        'http_method_override' => false,
        'php_errors' => ['log' => true],
    ];

    if ('test' === $container->env()) {
        $config['test'] = true;
    }

    $container->extension('framework', $config);
};

