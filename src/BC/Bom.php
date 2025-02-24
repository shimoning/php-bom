<?php
namespace Shimoning\Bom\BC;

/**
 * 後方互換版 (PHP7以前)
 */
class Bom
{
    /**
     * BOMのバイト列を取得する
     *
     * @return string
     */
    static public function get(string $charCode): string
    {
        $charCode = self::guess($charCode);
        if ($charCode === CharCode::UTF8) {
            return \pack('C*', 0xEF, 0xBB, 0xBF);
        } elseif ($charCode === CharCode::UTF16_BE) {
            return \pack('C*', 0xFE, 0xFF);
        } elseif ($charCode === CharCode::UTF16_LE) {
            return \pack('C*', 0xFF, 0xFE);
        } elseif ($charCode === CharCode::UTF32_BE) {
            return \pack('C*', 0x00, 0x00, 0xFE, 0xFF);
        } elseif ($charCode === CharCode::UTF32_LE) {
            return \pack('C*', 0xFF, 0xFE, 0x00, 0x00);
        }
        return '';
    }

    /**
     * BOMを文字列に付与する
     *
     * @param string $charCode
     * @param string $str
     * @return string
     */
    static public function prepend(string $charCode, string $str): string
    {
        return self::get($charCode) . $str;
    }

    /**
     * 文字列からBOMを取り除く
     *
     * @param string $charCode
     * @param string $str
     * @return string
     */
    static public function strip(string $charCode, string $str): string
    {
        $bom = self::get($charCode);
        return \str_starts_with($str, $bom)
            ? \substr($str, \strlen($bom))
            : $str;
    }

    /**
     * 文字コードを推測する
     *
     * @param string $charCode
     * @return string|null
     */
    static public function guess(string $charCode)
    {
        $charCode = strtoupper($charCode);
        if ($charCode === 'UTF-8' || $charCode === 'UTF8') {
            return CharCode::UTF8;
        } elseif ($charCode === 'UTF-16BE' || $charCode === 'UTF16_BE' || $charCode === 'UTF16BE') {
            return CharCode::UTF16_BE;
        } elseif ($charCode === 'UTF-16LE' || $charCode === 'UTF16_LE' || $charCode === 'UTF16LE' || $charCode === 'UTF-16' || $charCode === 'UTF16') {
            return CharCode::UTF16_LE;
        } elseif ($charCode === 'UTF-32BE' || $charCode === 'UTF32_BE' || $charCode === 'UTF32BE') {
            return CharCode::UTF32_BE;
        } elseif ($charCode === 'UTF-32LE' || $charCode === 'UTF32_LE' || $charCode === 'UTF32LE' || $charCode === 'UTF-32' || $charCode === 'UTF32') {
            return CharCode::UTF32_LE;
        }
        return null;
    }
}
