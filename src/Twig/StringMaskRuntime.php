<?php

namespace Bytes\StringMaskBundle\Twig;

use function Symfony\Component\String\u;

use Twig\Extension\RuntimeExtensionInterface;

class StringMaskRuntime implements RuntimeExtensionInterface
{
    public const DEFAULT_MASK = '...';

    /**
     * Replaces all characters aside from the first and final 3/$unmaskedCharacters with the $mask argument
     * If the string is less than $unmaskedCharacters * 2 + length of $mask characters long, it will reduce the mask
     * length until no longer possible then simply return an unmasked string.
     *
     * @param string $string
     * @param int    $unmaskedCharacters minimum of 3
     */
    public static function getMaskedString($string, string $mask = self::DEFAULT_MASK, int $unmaskedCharacters = 3): string
    {
        if (empty($string)) {
            return '';
        }

        if ($unmaskedCharacters < 1) {
            $unmaskedCharacters = 1;
        }

        $minLength = $unmaskedCharacters * 2 + strlen($mask);
        $absoluteMinLength = 2 + strlen($mask);

        $string = u($string);
        if ($string->length() < $absoluteMinLength) {
            return $string;
        }

        if ($string->length() < $minLength) {
            return static::getMaskedString($string, $mask, $unmaskedCharacters - 1);
        }

        return $string->splice($mask, $unmaskedCharacters, $string->length() - (2 * $unmaskedCharacters))->toString();
    }

    /**
     * A helper function based on substr[ing] that returns the leftmost $l characters.
     *
     * @param string $s The string
     * @param int    $l The number of characters to return (defaults to one character)
     */
    public static function left(string $s, int $l = 1): string
    {
        return self::leftRightHelper($s, $l, false);
    }

    /**
     * @param string $s The string
     * @param int    $l The number of characters to return
     */
    private static function leftRightHelper(string $s, int $l, bool $negativeOffset = false): string
    {
        $l = abs($l);
        if ($l < 1) {
            return '';
        }

        if (strlen($s) < 1) {
            return '';
        }

        if (strlen($s) <= $l) {
            return $s;
        }

        if ($negativeOffset) { // Right
            return substr($s, $l * -1);
        } else { // Left
            return substr($s, 0, $l);
        }
    }

    /**
     * A helper function based on substr[ing] that returns the rightmost $l characters.
     *
     * @param string $s The string
     * @param int    $l The number of characters to return (defaults to one character)
     */
    public static function right(string $s, int $l = 1): string
    {
        return self::leftRightHelper($s, $l, true);
    }
}
