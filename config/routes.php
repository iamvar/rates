<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function(RoutingConfigurator $routes) {
    $routes->import('../src/**/Controller/*', 'attribute');
};
