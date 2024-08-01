<?php

namespace Bytes\StringMaskBundle\Tests;

use Bytes\Common\Faker\TestFakerTrait;
use Bytes\StringMaskBundle\Twig\StringMaskRuntime;
use Generator;
use PHPUnit\Framework\TestCase;

use function Symfony\Component\String\u;

class StringMaskRuntimeTest extends TestCase
{
    use TestFakerTrait;

    /**
     * @dataProvider provide9PlusCharStrings
     */
    public function testGetMaskedString9Plus($string)
    {
        $masked = StringMaskRuntime::getMaskedString($string, '...');

        $input = u($string);
        $output = $input->slice(0, 3)->append('...')->append($input->slice(-3))->toString();

        self::assertEquals($output, $masked);
    }

    public function testGetEmptyMaskedString()
    {
        self::assertEmpty(StringMaskRuntime::getMaskedString('', '...'));
    }

    public function testGetNullMaskedString()
    {
        self::assertEmpty(StringMaskRuntime::getMaskedString(null, '...'));
    }

    /**
     * @dataProvider provideShortCharStrings
     */
    public function testGetMaskedStringShort($string, $output)
    {
        self::assertEquals($output, StringMaskRuntime::getMaskedString($string, '...'));
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
        self::setupFaker();

        foreach (range(9, 100) as $length) {
            yield ['string' => $this->faker->randomAlphanumericString($length)];
        }
    }

    public function testLeft()
    {
        self::assertEquals('abcd', StringMaskRuntime::left('abcde', 4));
        self::assertEquals('abcd', StringMaskRuntime::left('abcde', -4));
        self::assertEquals('5555', StringMaskRuntime::left(55555, 4));

        self::assertEmpty(StringMaskRuntime::left('abcde', 0));
        self::assertEmpty(StringMaskRuntime::left(''));

        self::assertEquals('abcde', StringMaskRuntime::left('abcde', 8));
    }

    public function testRight()
    {
        self::assertEquals('bcde', StringMaskRuntime::right('abcde', 4));
        self::assertEquals('bcde', StringMaskRuntime::right('abcde', -4));
        self::assertEquals('5555', StringMaskRuntime::right(55555, 4));

        self::assertEmpty(StringMaskRuntime::right('abcde', 0));
        self::assertEmpty(StringMaskRuntime::right(''));

        self::assertEquals('abcde', StringMaskRuntime::right('abcde', 8));
    }
}
