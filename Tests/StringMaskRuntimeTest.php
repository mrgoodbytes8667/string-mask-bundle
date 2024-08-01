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
    public function testGetMaskedString9Plus($string, $unmasked)
    {
        $masked = StringMaskRuntime::getMaskedString($string, mask: StringMaskRuntime::DEFAULT_MASK, unmaskedCharacters: $unmasked);

        $input = u($string);
        $output = $input->slice(0, $unmasked)->append(StringMaskRuntime::DEFAULT_MASK)->append($input->slice($unmasked * -1))->toString();

        self::assertEquals($output, $masked);
    }

    public function testGetEmptyMaskedString()
    {
        self::assertEmpty(StringMaskRuntime::getMaskedString('', mask: StringMaskRuntime::DEFAULT_MASK));
    }

    public function testGetNullMaskedString()
    {
        self::assertEmpty(StringMaskRuntime::getMaskedString(null, mask: StringMaskRuntime::DEFAULT_MASK));
    }

    /**
     * @dataProvider provideRangeNegative2Thru1
     *
     * @return void
     */
    public function testGetMaskedString0Unmasked($unmaskedCharacters)
    {
        self::assertSame('a...3', StringMaskRuntime::getMaskedString('abc123', mask: StringMaskRuntime::DEFAULT_MASK, unmaskedCharacters: $unmaskedCharacters));
    }

    public static function provideRangeNegative2Thru1(): Generator
    {
        foreach (range(-2, 1) as $i) {
            yield $i => [$i];
        }
    }

    /**
     * @dataProvider provideShortCharStrings
     */
    public function testGetMaskedStringShort($string, $output)
    {
        self::assertEquals($output, StringMaskRuntime::getMaskedString($string, mask: StringMaskRuntime::DEFAULT_MASK));
    }

    /**
     * @return Generator
     */
    public function provideShortCharStrings()
    {
        yield 'abcde12345' => ['string' => 'abcde12345', 'output' => 'abc...345'];
        yield 'abcde1234' => ['string' => 'abcde1234', 'output' => 'abc...234'];
        yield 'abcde123' => ['string' => 'abcde123', 'output' => 'ab...23'];
        yield 'abcde12' => ['string' => 'abcde12', 'output' => 'ab...12'];
        yield 'abc123' => ['string' => 'abc123', 'output' => 'a...3'];
        yield 'abc12' => ['string' => 'abc12', 'output' => 'a...2'];
        yield 'abc1' => ['string' => 'abc1', 'output' => 'abc1'];
        yield 'abc' => ['string' => 'abc', 'output' => 'abc'];
        yield 'ab' => ['string' => 'ab', 'output' => 'ab'];
        yield 'a' => ['string' => 'a', 'output' => 'a'];
    }

    /**
     * @return Generator
     */
    public function provide9PlusCharStrings()
    {
        self::setupFaker();

        foreach (range(3, 6) as $unmasked) {
            foreach (range(15, 100) as $length) {
                yield ['string' => $this->faker->randomAlphanumericString($length), 'unmasked' => $unmasked];
            }
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
