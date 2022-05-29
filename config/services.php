<?php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Iamvar\Rates\RateLoader\RateSourceInterface;
use Iamvar\Rates\RateLoader\Service\RateSourceCollection;

return static function(ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $ratesSourceTag = 'iamvar.rate-source';
    $services->instanceof(RateSourceInterface::class)
        ->tag($ratesSourceTag);


    $services->load('Iamvar\\Rates\\', '../src/**/Service/*');
    $services->load('Iamvar\\Rates\\', '../src/**/Command/*');

    $services->get(RateSourceCollection::class)->args(
            [tagged_locator($ratesSourceTag, 'key', 'getName')]
    );
};
