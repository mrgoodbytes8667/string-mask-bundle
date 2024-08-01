<?php

namespace Bytes\StringMaskBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringMaskExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('mask', [StringMaskRuntime::class, 'getMaskedString']),
        ];
    }
}
