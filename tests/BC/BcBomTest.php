<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Bom\BC\Bom;
use Shimoning\Bom\BC\CharCode;

class BcBomTest extends TestCase
{
    public function test_get()
    {
        $this->assertEquals(\pack('C*', 0xEF, 0xBB, 0xBF), Bom::get(CharCode::UTF8));
        $this->assertEquals(\pack('C*', 0xFE, 0xFF), Bom::get(CharCode::UTF16_BE));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE), Bom::get(CharCode::UTF16_LE));
        $this->assertEquals(\pack('C*', 0x00, 0x00, 0xFE, 0xFF), Bom::get(CharCode::UTF32_BE));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE, 0x00, 0x00), Bom::get(CharCode::UTF32_LE));
    }

    public function test_guess_utf8()
    {
        $this->assertSame(CharCode::UTF8, Bom::guess('UTF-8'));
        $this->assertSame(CharCode::UTF8, Bom::guess('UTF8'));
        $this->assertSame(CharCode::UTF8, Bom::guess('Utf8'));
        $this->assertSame(CharCode::UTF8, Bom::guess('utf8'));
    }

    public function test_guess_utf16_be()
    {
        $this->assertSame(CharCode::UTF16_BE, Bom::guess('UTF-16BE'));
        $this->assertSame(CharCode::UTF16_BE, Bom::guess('UTF16_BE'));
        $this->assertSame(CharCode::UTF16_BE, Bom::guess('Utf16Be'));
        $this->assertSame(CharCode::UTF16_BE, Bom::guess('utf16be'));
    }

    public function test_guess_utf16_le()
    {
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('UTF-16LE'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('UTF16_LE'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('Utf16Le'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('utf16le'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('UTF-16'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('UTF16'));
        $this->assertSame(CharCode::UTF16_LE, Bom::guess('utf16'));
    }

    public function test_guess_utf32_be()
    {
        $this->assertSame(CharCode::UTF32_BE, Bom::guess('UTF-32BE'));
        $this->assertSame(CharCode::UTF32_BE, Bom::guess('UTF32_BE'));
        $this->assertSame(CharCode::UTF32_BE, Bom::guess('Utf32Be'));
        $this->assertSame(CharCode::UTF32_BE, Bom::guess('utf32be'));
    }

    public function test_guess_utf32_le()
    {
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('UTF-32LE'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('UTF32_LE'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('Utf32Le'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('utf32le'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('UTF-32'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('UTF32'));
        $this->assertSame(CharCode::UTF32_LE, Bom::guess('utf32'));
    }
}
