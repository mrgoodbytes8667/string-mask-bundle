<?php

namespace Bytes\StringMaskBundle\Tests;

use Bytes\StringMaskBundle\Twig\StringMaskExtension;
use Bytes\StringMaskBundle\Twig\StringMaskRuntime;
use Twig\Extension\ExtensionInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Test\IntegrationTestCase;

class IntegrationTest extends IntegrationTestCase
{
    /**
     * @return ExtensionInterface[]
     */
    protected function getExtensions(): array
    {
        return [
            new StringMaskExtension(),
        ];
    }

    /**
     * @return RuntimeLoaderInterface[]
     */
    protected function getRuntimeLoaders()
    {
        return [
            new class() implements RuntimeLoaderInterface {
                public function load($class)
                {
                    if (StringMaskRuntime::class === $class) {
                        return new StringMaskRuntime();
                    }
                }
            },
        ];
    }

    /**
     * @return string
     */
    protected function getFixturesDir()
    {
        return __DIR__.'/Fixtures/';
    }
}
