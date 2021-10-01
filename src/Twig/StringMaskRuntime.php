<?php


namespace Bytes\StringMaskBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use function Symfony\Component\String\u;

/**
 * Class StringMaskRuntime
 * @package Bytes\StringMaskBundle\Twig
 */
class StringMaskRuntime implements RuntimeExtensionInterface
{
    /**
     * Replaces all characters aside from the first three and final three with the $mask argument
     *
     * @param string $string
     * @param string $mask
     * @return string
     */
    public static function getMaskedString($string, string $mask = '...'): string
    {
        if (empty($string)) {
            return '';
        }
        $string = u($string);
        if ($string->length() < 9) {
            return $string->splice($mask, 0, 1)->toString();
        }
        return $string->splice($mask, 3, $string->length() - 6)->toString();
    }

    /**
     * A helper function based on substr[ing] that returns the leftmost $l characters
     * @param string $s The string
     * @param integer $l The number of characters to return (defaults to one character)
     *
     * @return string
     */
    public static function left(string $s, int $l = 1): string
    {
        return self::leftRightHelper($s, $l, false);
    }

    /**
     * @param string $s The string
     * @param int $l The number of characters to return
     * @param bool $negativeOffset
     *
     * @return string
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
        if ($negativeOffset) // Right
        {
            return substr($s, $l * -1);
        } else { // Left
            return substr($s, 0, $l);
        }
    }

    /**
     * A helper function based on substr[ing] that returns the rightmost $l characters
     * @param string $s The string
     * @param integer $l The number of characters to return (defaults to one character)
     *
     * @return string
     */
    public static function right(string $s, int $l = 1): string
    {
        return self::leftRightHelper($s, $l, true);
    }
}