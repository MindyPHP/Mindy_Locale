<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/08/16
 * Time: 09:00
 */

namespace Mindy\Locale\Tests;


use Mindy\Locale\Timestamp;

class TimestampTest extends \PHPUnit_Framework_TestCase
{
    public function testDayOfWeek()
    {
        $w = Timestamp::getDayofWeek(2016, 8, 10);
        $this->assertEquals(3, $w);
        $w = Timestamp::getDayofWeek(1456, 8, 10);
        $this->assertEquals(3, $w);
        $w = Timestamp::getDayofWeek(1456, 1, 10);
        $this->assertEquals(0, $w);
    }

    public function testIsLeapYear()
    {
        $this->assertTrue(Timestamp::isLeapYear(2016));
        $this->assertFalse(Timestamp::isLeapYear(2015));
        $this->assertTrue(Timestamp::isLeapYear(2000));
        $this->assertFalse(Timestamp::isLeapYear(2100));
    }

    public function testGet4DigitYear()
    {
        $this->assertEquals(2009, Timestamp::get4DigitYear(9));
        $this->assertEquals(1966, Timestamp::get4DigitYear(66));
        $this->assertEquals(1951, Timestamp::get4DigitYear(51));
    }

    public function testGetGMTDiff()
    {
        $this->assertEquals(0, Timestamp::getGMTDiff());
    }

    public function testGetDate()
    {
        $this->assertEquals([
            'seconds' => 0,
            'minutes' => 0,
            'hours' => 0,
            'mday' => 10,
            'wday' => 2,
            'mon' => 8,
            'year' => 2010,
            'yday' => 221,
            'weekday' => 'Tuesday',
            'month' => 'August',
            0 => 1281398400
        ], Timestamp::getDate(strtotime('10.08.2010')));

        $this->assertEquals([
            'seconds' => 0,
            'minutes' => 0,
            'hours' => 0,
            'mday' => 10,
            'wday' => 2,
            'mon' => 8,
            'year' => 2010,
            'yday' => 221,
            'weekday' => 'Tuesday',
            'month' => 'August',
            0 => 1281398400
        ], Timestamp::getDate(strtotime('10.08.2010'), true));
    }

    public function testIsValidDate()
    {
        $this->assertTrue(Timestamp::isValidDate(2010, 8, 10));
        $this->assertFalse(Timestamp::isValidDate(2010, 13, 10));
    }

    public function testIsValidTime()
    {
        $this->assertTrue(Timestamp::isValidTime(10, 10, 10, true));
        $this->assertFalse(Timestamp::isValidTime(30, 30, 30, false));

        $this->assertFalse(Timestamp::isValidTime(10, 30, -10, false));
        $this->assertFalse(Timestamp::isValidTime(10, 61, 10, false));
    }

    public function testGetTimestamp()
    {
        $this->assertEquals(1286705410, Timestamp::getTimestamp(10, 10, 10, 10, 10, 2010));
        $this->assertEquals(1470823810, Timestamp::getTimestamp(10, 10, 10, false, 10, 2010, true));
        $this->assertEquals(1470823810, Timestamp::getTimestamp(10, 10, 10, false, 10, 2010, false));
    }

    public function testFormatDate()
    {
        // year
        $this->assertEquals(date('Y'), Timestamp::formatDate('Y'));
        $this->assertEquals(2010, Timestamp::formatDate('Y', strtotime('10.10.2010')));
        $this->assertEquals('UTC', Timestamp::formatDate('T', 2147483647 + 10));
        $this->assertEquals('Tue, 19 Jan 2038 03:14:17 +0000', Timestamp::formatDate('r', 2147483647 + 10));
        $this->assertEquals(2038, Timestamp::formatDate('Y', 2147483647 + 10));
        $this->assertEquals(38, Timestamp::formatDate('y', 2147483647 + 10));
        // month
        $this->assertEquals(01, Timestamp::formatDate('m', 2147483647 + 10));
        $this->assertEquals(01, Timestamp::formatDate('m', 2147483647 + 10));
        $this->assertEquals(01, Timestamp::formatDate('Q', 2147483647 + 10));
        $this->assertEquals(01, Timestamp::formatDate('n', 2147483647 + 10));
        $this->assertEquals('Jan', Timestamp::formatDate('M', 2147483647 + 10));
        $this->assertEquals('January', Timestamp::formatDate('F', 2147483647 + 10));
        // day
        $this->assertEquals('18', Timestamp::formatDate('z', 2147483647 + 10));
        $this->assertEquals('2', Timestamp::formatDate('w', 2147483647 + 10));
        $this->assertEquals('Tuesday', Timestamp::formatDate('l', 2147483647 + 10));
        $this->assertEquals('Tue', Timestamp::formatDate('D', 2147483647 + 10));
        $this->assertEquals('19', Timestamp::formatDate('j', 2147483647 + 10));
        $this->assertEquals('19', Timestamp::formatDate('d', 2147483647 + 10));
        $this->assertEquals('th', Timestamp::formatDate('S', 2147483647 + 10));
        // hour
        $this->assertEquals('0', Timestamp::formatDate('Z', 2147483647 + 10));
        $this->assertEquals('0', Timestamp::formatDate('O', 2147483647 + 10));
        $this->assertEquals('03', Timestamp::formatDate('H', 2147483647 + 10));
        $this->assertEquals('03', Timestamp::formatDate('h', 2147483647 + 10));
        $this->assertEquals('03', Timestamp::formatDate('G', 2147483647 + 10));
        $this->assertEquals('03', Timestamp::formatDate('g', 2147483647 + 10));
        // minutes
        $this->assertEquals('14', Timestamp::formatDate('i', 2147483647 + 10));
        // seconds
        $this->assertEquals(2147483657, Timestamp::formatDate('U', 2147483647 + 10));
        $this->assertEquals(17, Timestamp::formatDate('s', 2147483647 + 10));
        // am/pm
        $this->assertEquals('am', Timestamp::formatDate('a', 2147483647 + 10));
        $this->assertEquals('AM', Timestamp::formatDate('A', 2147483647 + 10));
    }
}