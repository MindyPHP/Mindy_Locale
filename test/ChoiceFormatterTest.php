<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 09/08/16
 * Time: 21:31
 */

namespace Mindy\Locale\Tests;

use Mindy\Locale\Locale;

class ChoiceFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Locale
     */
    public $t;

    public function setUp()
    {
        $this->t = new Locale([
            'sourceLanguage' => 'en',
            'loader' => [
                'class' => '\Mindy\Locale\Loader\PhpSourceLoader',
                'basePath' => __DIR__ . '/data',
            ],
        ]);
    }

    // Choice: 'expr1#msg1|expr2#msg2|expr3#msg3'
    public function testChoice()
    {
        $this->t->setLanguage('ru');
        // simple choices
//        $this->assertEquals('одна книга', $this->t->t('test', 'n==1#one book|n>1#many books', 1));
//        $this->assertEquals('много книг', $this->t->t('test', 'n==1#one book|n>1#many books', 10));
//        $this->assertEquals('одна книга', $this->t->t('test', '1#one book|n>1#many books', 1));
        $this->assertEquals('много книг', $this->t->t('test', '1#one book|n>1#many books', 10));
    }
}