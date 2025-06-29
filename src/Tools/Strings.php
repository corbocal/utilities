<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

class Strings
{
    private function __construct()
    {
    }

    /**
     * Returns the position of the nth occurrence of a character in a string.
     *
     * @param string $char the looked for character
     * @param string $subject the string to search in
     * @param int $occurence the occurence of the character
     *
     * @return ?int the position | null if error or not found
     */
    public static function getNthCharacterIndex(string $char, string $subject, int $occurence): ?int
    {
        if (\mb_strlen($char) !== 1) {
            return null;
        }

        \preg_match_all("/$char/", $subject, $matches, PREG_OFFSET_CAPTURE);

        return \array_key_exists($occurence - 1, $matches[0]) ? $matches[0][$occurence - 1][1] : null;
    }

    /**
     * Capitalizes the first letter of a multibyte string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function mbUcFirst(string $string): string
    {
        return \mb_strtoupper(\mb_substr($string, 0, 1)) . \mb_substr($string, 1);
    }

    /**
     * Converts all accentuated characters with their non-accuented version in a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function convertAccents(string $string)
    {
        $transliterator = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $result = \transliterator_transliterate($transliterator, $string) ? $string : $string;

        return $result;
    }

    /**
     * Converts a string into a "slugified" version, i.e without accents and dashes instead of spaces.
     *
     * @param string $string
     *
     * @return string
     */
    public static function mbSlugify(string $string)
    {
        $string = \str_replace(["\xc2\xa0", " ", "&nbsp;"], "-", $string);
        $transliterator = 'Any-Latin; Latin-ASCII; [^A-Za-z0-9-] remove; lower()';
        $result = \transliterator_transliterate($transliterator, $string) ? $string : $string;

        return $result;
    }

    /**
     * Removes all non printable characters from a string
     *
     * @param string $string
     *
     * @return string
     */
    public static function fullTrim(string $string): string
    {
        /** @var string */
        $firstTrim = \preg_replace("/\n+|\t+/", " ", $string);
        /** @var string */
        $result = \preg_replace('/\s+/', ' ', $firstTrim);

        return trim($result);
    }

    /**
     * Returns the class name (same as php filename) from a fully qualified class name (FQCN).
     *
     * @param string $fqcn
     *
     * @return string
     */
    public static function className(string $fqcn): string
    {
        $explodedFqcn = \explode("\\", $fqcn);
        return \array_pop($explodedFqcn);
    }
}
