<?php

namespace Mindy\Locale\Tests;

use Mindy\Helper\Alias;
use Mindy\Locale\Loader\PhpSourceLoader;
use Mindy\Locale\Locale;

class PhpMessageSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testModuleTranslation()
    {
        $t = new Locale([
            'loader' => ['class' => PhpSourceLoader::class]
        ]);
        Alias::set('PhpMessageSourceTest.messages', dirname(__FILE__) . '/messages');
        $t->setLanguage('de_DE');
        $t->getLoader()->extensionPaths['MyTestExtension'] = 'PhpMessageSourceTest.messages';
        $this->assertEquals('Hallo Welt!', $t->t('MyTestExtension.testcategory', 'Hello World!'));
    }
}
