<?php

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $framework->secret('%env(APP_SECRET)%')
        ->httpMethodOverride(false)
        ->phpErrors(['log' => true]);

    $framework->router([
        'strict_requirements' => null,
    ]);
};

