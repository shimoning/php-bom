<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Bom\BC\Bom;
use Shimoning\Bom\BC\CharCode;

class BcBomTest extends TestCase
{
    public function test_get()
    {
        // utf8
        $bom = Bom::get(CharCode::UTF8);
        $this->assertEquals(\pack('C*', 0xEF, 0xBB, 0xBF), $bom);
        $this->assertEquals(3, \strlen($bom));

        // utf16be
        $bom = Bom::get(CharCode::UTF16_BE);
        $this->assertEquals(\pack('C*', 0xFE, 0xFF), $bom);
        $this->assertEquals(2, \strlen($bom));

        // utf16le
        $bom = Bom::get(CharCode::UTF16_LE);
        $this->assertEquals(\pack('C*', 0xFF, 0xFE), $bom);
        $this->assertEquals(2, \strlen($bom));

        // utf32be
        $bom = Bom::get(CharCode::UTF32_BE);
        $this->assertEquals(\pack('C*', 0x00, 0x00, 0xFE, 0xFF), $bom);
        $this->assertEquals(4, \strlen($bom));

        // utf32le
        $bom = Bom::get(CharCode::UTF32_LE);
        $this->assertEquals(\pack('C*', 0xFF, 0xFE, 0x00, 0x00), $bom);
        $this->assertEquals(4, \strlen($bom));
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

    public function test_prepend()
    {
        // utf8
        $prepended = Bom::prepend(CharCode::UTF8, 'abc');
        $this->assertEquals(\pack('C*', 0xEF, 0xBB, 0xBF) . 'abc', $prepended);
        $this->assertEquals(6, \strlen($prepended));

        // others
        $this->assertEquals(\pack('C*', 0xFE, 0xFF) . 'abc', Bom::prepend(CharCode::UTF16_BE, 'abc'));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE) . 'abc', Bom::prepend(CharCode::UTF16_LE, 'abc'));
        $this->assertEquals(\pack('C*', 0x00, 0x00, 0xFE, 0xFF) . 'abc', Bom::prepend(CharCode::UTF32_BE, 'abc'));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE, 0x00, 0x00) . 'abc', Bom::prepend(CharCode::UTF32_BE, 'abc'));
    }

    public function test_strip()
    {
        // utf8
        $stripped = Bom::strip(CharCode::UTF8, \pack('C*', 0xEF, 0xBB, 0xBF) . 'abc');
        $this->assertEquals('abc', $stripped);
        $this->assertEquals(3, \strlen($stripped));

        // others
        $this->assertEquals('abc', Bom::strip(CharCode::UTF16_BE, \pack('C*', 0xFE, 0xFF) . 'abc'));
        $this->assertEquals('abc', Bom::strip(CharCode::UTF16_LE, \pack('C*', 0xFF, 0xFE) . 'abc'));
        $this->assertEquals('abc', Bom::strip(CharCode::UTF32_BE, \pack('C*', 0x00, 0x00, 0xFE, 0xFF) . 'abc'));
        $this->assertEquals('abc', Bom::strip(CharCode::UTF32_BE, \pack('C*', 0xFF, 0xFE, 0x00, 0x00) . 'abc'));
    }
}
