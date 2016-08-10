<?php

namespace Mindy\Locale\Tests;

use Mindy\Locale\Loader\PhpSourceLoader;
use Mindy\Locale\MessageSource;
use Mindy\Locale\Locale;

/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/10/14.10.2014 15:49
 */
class TranslateTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $t = new Locale([
            'source' => [
                'messages' => [
                    'class' => '\Mindy\Locale\Loader\PhpSourceLoader',
                ]
            ]
        ]);

        $this->assertInstanceOf(PhpSourceLoader::class, $t->getLoader());

        $this->assertEquals('en_us', $t->getLanguage());

        $this->assertEquals('', $t->t('base', ''));
        $this->assertEquals('foo', $t->t('base', 'foo'));
    }
}
