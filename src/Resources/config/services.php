<?php


namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Bytes\StringMaskBundle\Twig\StringMaskRuntime;
use Bytes\StringMaskBundle\Twig\StringMaskExtension;

/**
 * @param ContainerConfigurator $container
 */
return static function (ContainerConfigurator $container) {

    $services = $container->services();

    $services->set('bytes_string_mask.string_mask_extension', StringMaskExtension::class)
        ->tag('twig.extension');

    $services->set('bytes_string_mask.string_mask_runtime', StringMaskRuntime::class)
        ->tag('twig.runtime');

};