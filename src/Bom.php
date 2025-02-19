<?php

namespace Shimoning\Bom;

/**
 * Byte Order Mark
 *
 * @link https://ja.wikipedia.org/wiki/%E3%83%90%E3%82%A4%E3%83%88%E9%A0%86%E3%83%9E%E3%83%BC%E3%82%AF
 */
enum Bom: string
{
    case UTF8 = 'UTF-8';
    case UTF16_BE = 'UTF-16_BE';
    case UTF16_LE = 'UTF-16_LE';
    case UTF32_BE = 'UTF-32_BE';
    case UTF32_LE = 'UTF-32_LE';
    // case UTF7 = 'UTF-7';

    public function get(): string
    {
        return match ($this) {
            self::UTF8 => \pack('C*', 0xEF, 0xBB, 0xBF),
            self::UTF16_BE => \pack('C*', 0xFE, 0xFF),
            self::UTF16_LE => \pack('C*', 0xFF, 0xFE),
            self::UTF32_BE => \pack('C*', 0x00, 0x00, 0xFE, 0xFF),
            self::UTF32_LE => \pack('C*', 0xFF, 0xFE, 0x00, 0x00),

            // 最後の値は、後続文字のバイトの値によって異なり、0x38、0x39、0x2B、0x2Fのいずれか
            // self::UTF7 => \pack('C*', 0x2B, 0x2F, 0x76),
        };
    }

    /**
     * 文字列としての文字コードから、BOMが使える文字コードを推測する
     *
     * @param string $charCode
     * @return self|null
     */
    static public function guess(string $charCode): ?self
    {
        return match (\strtoupper($charCode)) {
            'UTF-8', 'UTF8' => self::UTF8,
            'UTF-16BE', 'UTF16_BE', 'UTF16BE' => self::UTF16_BE,
            'UTF-16LE', 'UTF16_LE', 'UTF16LE', 'UTF-16', 'UTF16' => self::UTF16_LE,
            'UTF-32BE', 'UTF32_BE', 'UTF32BE' => self::UTF32_BE,
            'UTF-32LE', 'UTF32_LE', 'UTF32LE', 'UTF-32', 'UTF32' => self::UTF32_LE,
            // 'UTF-7', 'UTF7' => self::UTF7,
            default => null,
        };
    }
}
