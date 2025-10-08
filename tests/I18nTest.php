<?php
use PHPUnit\Framework\TestCase;

use Piko\I18n;
use function Piko\I18n\__;

class I18nTest extends TestCase
{
    protected function setUp(): void
    {
        Piko::setAlias('@app', __DIR__);
    }

    protected function tearDown(): void
    {
        Piko::reset();
    }

    public function testWithConfig()
    {
        $translations = ['test' => '@app/messages'];
        $i18n = new I18n($translations, 'fr');
        I18n::setInstance($i18n);

        $this->assertEquals('Test de traduction', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
        $this->assertEquals('Test de traduction', __('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', __('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testAddTranslation()
    {
        $i18n = new I18n([], 'fr');
        $i18n->addTranslation('test', '@app/messages');
        I18n::setInstance($i18n);

        $this->assertEquals('Test de traduction', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
        $this->assertEquals('Test de traduction', __('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', __('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testUnregisteredTranslation()
    {
        $i18n = new I18n();
        $this->assertEquals('Translation test', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Hello Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testUnregisteredTranslationWithProxyFunction()
    {
        I18n::setInstance(null);
        $this->expectException(\RuntimeException::class);
        __('test', 'Translation test');
    }
}
