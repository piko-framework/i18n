<?php

/**
 * This file is part of Piko framework
 *
 * @copyright 2019-2022 Sylvain PHILIP
 * @license LGPL-3.0; see LICENSE.txt
 * @link https://github.com/piko-framework/i18n
 */

declare(strict_types=1);

namespace Piko;

use Piko\I18n\Event\AfterTranslateEvent;
use Piko\I18n\Event\BeforeTranslateEvent;

/**
 * Internationalization class
 *
 * @author Sylvain PHILIP <contact@sphilip.com>
 */
class I18n
{
    use EventHandlerTrait;

    /**
     * The language code currently used for translations
     *
     * @var string
     */
    public $language = '';

    /**
     * A key-value paired array of domain / path
     *
     * @var array<string, string>
     */
    public $translations = [];

    /**
     * Messages container by domain
     *
     * @var array<array<string, string>>
     */
    protected $messages = [];

    /**
     * I18n Instance
     *
     * @var I18n|null
     */
    protected static $instance = null;

    /**
     * Constructor
     * The $translations argument should contains a key-value paired array of domain / path.
     *
     * Example :
     *
     * ```php
     * [
     *    'app' => '@app/messages'
     * ]
     * ```
     *
     * @param array<string, string> $translations
     * @param string $language The language code
     */
    public function __construct(array $translations = [], string $language = 'en')
    {
        $this->language = $language;
        $this->translations = $translations;
    }

    /**
     * Return I18n singleton instance
     *
     * @return null|I18n
     */
    public static function getInstance(): ?I18n
    {
        return static::$instance;
    }

    /**
     * Set the i18n instance for the \I18n\__ function
     *
     * @param I18n|null $instance The i18n instance
     */
    public static function setInstance(?I18n $instance): void
    {
        static::$instance = $instance;
    }

    /**
     * Reset singleton instance
     */
    public static function reset(): void
    {
        static::$instance = null;
    }

    /**
     * Load translation messages
     */
    protected function loadTranslations(string $domain): void
    {
        foreach ($this->translations as $d => $path) {
            if ($d == $domain) {
                $file = \Piko::getAlias("{$path}/{$this->language}.php");

                if (is_string($file) && file_exists($file)) {
                    $this->messages[$domain] = require $file;
                }

                break;
            }
        }
    }

    /**
     * Register a translation
     *
     * @param string $domain The translation domain, for instance 'app'.
     * @param string $path The path to the directory where to find translation files.
     * @return void
     */
    public function addTranslation(string $domain, string $path): void
    {
        $this->translations[$domain] = $path;
    }

    /**
     * Translate a text.
     *
     * @param string $domain The translation domain, for instance 'app'.
     * @param string|null $text The text to translate.
     * @param array<string, string> $params Parameters substitution,
     *                                               eg. $this->translate('site', 'Hello {name}', ['name' => 'John']).
     *
     * @return string|null The translated text or the text itself if no translation was found (the text can be null).
     */
    public function translate(string $domain, ?string $text, array $params = []): ?string
    {
        if (empty($this->messages[$domain])) {
            $this->loadTranslations($domain);
        }

        $event = new BeforeTranslateEvent($domain, $text, $params);

        $this->trigger($event);

        if (is_string($text)) {
            $text = $this->messages[$event->domain][$event->text] ?? $text;

            foreach ($event->params as $k => $v) {
                $text = str_replace('{' . $k . '}', $v, $text);
            }
        }

        $event = new AfterTranslateEvent($domain, $text);

        $this->trigger($event);

        return $event->text;
    }
}
