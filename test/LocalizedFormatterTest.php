<?php

namespace Mindy\Locale\Tests;

use Mindy\Locale\Formatter\LocalizedFormatter;
use Mindy\Locale\Locale;
use Mindy\Locale\LocaleData;

class LocalizedFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Locale
     */
    protected $l;
    /**
     * @var LocalizedFormatter
     */
    protected $f;

    public function setUp()
    {
        $this->l = new Locale([
            'sourceLanguage' => 'en',
            'source' => [
                'messages' => [
                    'class' => '\Mindy\Locale\Loader\PhpSourceLoader',
                ],
            ],
        ]);
        $this->f = new LocalizedFormatter($this->l);
    }

    public function tearDown()
    {
        $this->l = $this->f = null;
    }

    public function testBool()
    {
        $this->assertEquals('Yes', $this->f->formatBoolean(1));
        $this->assertEquals('No', $this->f->formatBoolean(0));

        $this->l->setLanguage('ru');
        $this->assertEquals('Да', $this->f->formatBoolean(1));
        $this->assertEquals('Нет', $this->f->formatBoolean(0));
    }

    public function testFormatDate()
    {
        $this->assertEquals('Oct 10, 1970', $this->f->formatDate(strtotime('10.10.1970')));

        $this->l->setLanguage('ru');
        $this->assertEquals('10.10.1970', $this->f->formatDate(strtotime('10.10.1970')));
    }

    public function testFormatTime()
    {
        $this->assertEquals('11:00:00 PM', $this->f->formatTime(strtotime('10.10.1970 23:00')));

        $this->l->setLanguage('ru');
        $this->assertEquals('23:00:00', $this->f->formatTime(strtotime('10.10.1970 23:00')));
    }

    public function testFormatDateTime()
    {
        $this->assertEquals('Oct 10, 1970 11:00:00 PM', $this->f->formatDatetime(strtotime('10.10.1970 23:00')));

        $this->l->setLanguage('ru');
        $this->assertEquals('10.10.1970, 23:00:00', $this->f->formatDatetime(strtotime('10.10.1970 23:00')));
    }

    public function testFormatNumber()
    {
        $this->assertEquals('10,000', $this->f->formatNumber(10000));

        $this->l->setLanguage('ru');
        $this->assertEquals('10 000', $this->f->formatNumber(10000));
    }
}