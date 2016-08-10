<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/08/16
 * Time: 08:26
 */

namespace Mindy\Locale\Tests;

use Exception;
use Mindy\Locale\LocaleData;

class LocaleDataTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $l = new LocaleData('ru');
        $this->assertEquals('ru', $l->getId());
    }

    public function testLocaleIds()
    {
        $ids = LocaleData::getLocaleIDs();
        $this->assertEquals(659, count($ids));
    }

    public function testGetMonthNames()
    {
        $l = new LocaleData('ru');
        $this->assertEquals([
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь'
        ], $l->getMonthNames('wide', true));
    }

    public function testGetWeekDayName()
    {
        $l = new LocaleData('ru');
        $this->assertEquals('Понедельник', $l->getWeekDayName(1, 'wide', true));
    }

    public function testGetWeekDayNames()
    {
        $l = new LocaleData('ru');
        $this->assertEquals([
            0 => 'Воскресенье',
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота'
        ], $l->getWeekDayNames('wide', true));
    }

    public function testConstructException()
    {
        $this->setExpectedException(Exception::class);
        new LocaleData('Unknown_123');
    }
}