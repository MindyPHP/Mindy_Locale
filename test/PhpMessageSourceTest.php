<?php

namespace Mindy\Locale\Tests;

use Mindy\Helper\Alias;
use Mindy\Locale\Locale;

class PhpMessageSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testModuleTranslation()
    {
        Alias::set('PhpMessageSourceTest.messages', __DIR__ . '/messages');

        $t = new Locale([
            'loader' => [
                'class' => '\Mindy\Locale\Loader\PhpSourceLoader',
                'basePath' => __DIR__ . '/messages',
            ],
        ]);
        $t->setLanguage('de_DE');
        $this->assertEquals('de_DE', $t->getLanguage());
        $this->assertEquals('Hallo Welt!', $t->t('testcategory', 'Hello World!'));
    }
}
