<?php
use PHPUnit\Framework\TestCase;
use piko\Piko;
use piko\I18n;

class I18nTest extends TestCase
{
    protected function setUp(): void
    {
        Piko::setAlias('@app', __DIR__);
        Piko::set('language', 'fr');
    }

    protected function tearDown(): void
    {
        Piko::reset();
    }

    public function testWithConfig()
    {
        $config = [
            'translations' => [
                'test' => '@app/messages'
            ]
        ];

        $i18n = new I18n($config);
        Piko::set('i18n', $i18n);

        $this->assertEquals('Test de traduction', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
        $this->assertEquals('Test de traduction', __('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', __('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testAddTranslation()
    {
        $i18n = new I18n();
        Piko::set('i18n', $i18n);
        $i18n->addTranslation('test', '@app/messages');

        $this->assertEquals('Test de traduction', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
        $this->assertEquals('Test de traduction', __('test', 'Translation test'));
        $this->assertEquals('Bonjour Toto', __('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testUnregisteredTranslation()
    {
        $i18n = new I18n([]);
        $this->assertEquals('Translation test', $i18n->translate('test', 'Translation test'));
        $this->assertEquals('Hello Toto', $i18n->translate('test', 'Hello {name}', ['name' => 'Toto']));
    }

    public function testNotRegisteredI18nComponent()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('i18n must be instance of piko\I18n');
        __('test', 'Translation test');
    }
}
