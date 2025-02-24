<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Bom\Bom;

class BomTest extends TestCase
{
    public function test_get()
    {
        // utf8
        $bom = Bom::UTF8->get();
        $this->assertEquals(\pack('C*', 0xEF, 0xBB, 0xBF), $bom);
        $this->assertEquals(3, \strlen($bom));

        // utf16be
        $bom = Bom::UTF16_BE->get();
        $this->assertEquals(\pack('C*', 0xFE, 0xFF), $bom);
        $this->assertEquals(2, \strlen($bom));

        // utf16le
        $bom = Bom::UTF16_LE->get();
        $this->assertEquals(\pack('C*', 0xFF, 0xFE), $bom);
        $this->assertEquals(2, \strlen($bom));

        // utf32be
        $bom = Bom::UTF32_BE->get();
        $this->assertEquals(\pack('C*', 0x00, 0x00, 0xFE, 0xFF), $bom);
        $this->assertEquals(4, \strlen($bom));

        // utf32le
        $bom = Bom::UTF32_LE->get();
        $this->assertEquals(\pack('C*', 0xFF, 0xFE, 0x00, 0x00), $bom);
        $this->assertEquals(4, \strlen($bom));
    }

    public function test_guess_utf8()
    {
        $this->assertSame(Bom::UTF8, Bom::guess('UTF-8'));
        $this->assertSame(Bom::UTF8, Bom::guess('UTF8'));
        $this->assertSame(Bom::UTF8, Bom::guess('Utf8'));
        $this->assertSame(Bom::UTF8, Bom::guess('utf8'));
    }

    public function test_guess_utf16_be()
    {
        $this->assertSame(Bom::UTF16_BE, Bom::guess('UTF-16BE'));
        $this->assertSame(Bom::UTF16_BE, Bom::guess('UTF16_BE'));
        $this->assertSame(Bom::UTF16_BE, Bom::guess('Utf16Be'));
        $this->assertSame(Bom::UTF16_BE, Bom::guess('utf16be'));
    }

    public function test_guess_utf16_le()
    {
        $this->assertSame(Bom::UTF16_LE, Bom::guess('UTF-16LE'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('UTF16_LE'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('Utf16Le'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('utf16le'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('UTF-16'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('UTF16'));
        $this->assertSame(Bom::UTF16_LE, Bom::guess('utf16'));
    }

    public function test_guess_utf32_be()
    {
        $this->assertSame(Bom::UTF32_BE, Bom::guess('UTF-32BE'));
        $this->assertSame(Bom::UTF32_BE, Bom::guess('UTF32_BE'));
        $this->assertSame(Bom::UTF32_BE, Bom::guess('Utf32Be'));
        $this->assertSame(Bom::UTF32_BE, Bom::guess('utf32be'));
    }

    public function test_guess_utf32_le()
    {
        $this->assertSame(Bom::UTF32_LE, Bom::guess('UTF-32LE'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('UTF32_LE'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('Utf32Le'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('utf32le'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('UTF-32'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('UTF32'));
        $this->assertSame(Bom::UTF32_LE, Bom::guess('utf32'));
    }

    public function test_prepend()
    {
        // utf8
        $appended = Bom::UTF8->prepend('abc');
        $this->assertEquals(\pack('C*', 0xEF, 0xBB, 0xBF) . 'abc', $appended);
        $this->assertEquals(6, \strlen($appended));

        // others
        $this->assertEquals(\pack('C*', 0xFE, 0xFF) . 'abc', Bom::UTF16_BE->prepend('abc'));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE) . 'abc', Bom::UTF16_LE->prepend('abc'));
        $this->assertEquals(\pack('C*', 0x00, 0x00, 0xFE, 0xFF) . 'abc', Bom::UTF32_BE->prepend('abc'));
        $this->assertEquals(\pack('C*', 0xFF, 0xFE, 0x00, 0x00) . 'abc', Bom::UTF32_LE->prepend('abc'));
    }

    public function test_strip()
    {
        // utf8
        $stripped = Bom::UTF8->strip(\pack('C*', 0xEF, 0xBB, 0xBF) . 'abc');
        $this->assertEquals('abc', $stripped);
        $this->assertEquals(3, \strlen($stripped));

        // others
        $this->assertEquals('abc', Bom::UTF16_BE->strip(\pack('C*', 0xFE, 0xFF) . 'abc'));
        $this->assertEquals('abc', Bom::UTF16_LE->strip(\pack('C*', 0xFF, 0xFE) . 'abc'));
        $this->assertEquals('abc', Bom::UTF32_BE->strip(\pack('C*', 0x00, 0x00, 0xFE, 0xFF) . 'abc'));
        $this->assertEquals('abc', Bom::UTF32_LE->strip(\pack('C*', 0xFF, 0xFE, 0x00, 0x00) . 'abc'));
    }
}
