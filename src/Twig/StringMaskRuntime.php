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
}