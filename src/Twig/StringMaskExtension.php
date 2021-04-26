<?php


namespace Bytes\StringMaskBundle\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class StringMaskExtension
 * @package Bytes\StringMaskBundle\Twig
 */
class StringMaskExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('mask', [StringMaskRuntime::class, 'getMaskedString']),
        ];
    }
}