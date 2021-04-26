<?php

namespace Bytes\StringMaskBundle\Tests\Twig;

use Bytes\Common\Faker\TestFakerTrait;
use Bytes\StringMaskBundle\Twig\StringMaskRuntime;
use Generator;
use PHPUnit\Framework\TestCase;
use function Symfony\Component\String\u;

/**
 * Class StringMaskRuntimeTest
 * @package Bytes\StringMaskBundle\Tests\Twig
 */
class StringMaskRuntimeTest extends TestCase
{
    use TestFakerTrait;

    /**
     * @dataProvider provide9PlusCharStrings
     * @param $string
     */
    public function testGetMaskedString9Plus($string)
    {
        $masked = StringMaskRuntime::getMaskedString($string, '...');

        $input = u($string);
        $output = $input->slice(0, 3)->append('...')->append($input->slice(-3))->toString();

        $this->assertEquals($output, $masked);
    }

    /**
     *
     */
    public function testGetEmptyMaskedString()
    {
        $this->assertEmpty(StringMaskRuntime::getMaskedString('', '...'));
    }

    /**
     *
     */
    public function testGetNullMaskedString()
    {
        $this->assertEmpty(StringMaskRuntime::getMaskedString(null, '...'));
    }

    /**
     * @dataProvider provideShortCharStrings
     * @param $string
     * @param $output
     */
    public function testGetMaskedStringShort($string, $output)
    {
        $this->assertEquals($output, StringMaskRuntime::getMaskedString($string, '...'));
    }

    /**
     * @return Generator
     */
    public function provideShortCharStrings()
    {
        yield ['string' => 'abcde12345', 'output' => 'abc...345'];
        yield ['string' => 'abcde1234', 'output' => 'abc...234'];
        yield ['string' => 'abcde123', 'output' => '...bcde123'];
        yield ['string' => 'abcde12', 'output' => '...bcde12'];
        yield ['string' => 'abc123', 'output' => '...bc123'];
        yield ['string' => 'abc12', 'output' => '...bc12'];
        yield ['string' => 'abc1', 'output' => '...bc1'];
        yield ['string' => 'abc', 'output' => '...bc'];
        yield ['string' => 'ab', 'output' => '...b'];
        yield ['string' => 'a', 'output' => '...'];
    }

    /**
     * @return Generator
     */
    public function provide9PlusCharStrings()
    {
        $this->setupFaker();

        foreach (range(9, 100) as $length) {
            yield ['string' => $this->faker->randomAlphanumericString($length)];
        }
    }
}