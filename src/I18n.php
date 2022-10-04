<?php

/**
 * This file is part of Piko framework
 *
 * @copyright 2019-2022 Sylvain PHILIP
 * @license LGPL-3.0; see LICENSE.txt
 * @link https://github.com/piko-framework/i18n
 */

declare(strict_types=1);

namespace piko;

/**
 * Internationalization class
 *
 * @author Sylvain PHILIP <contact@sphilip.com>
 */
class I18n extends Component
{
    /**
     * Messages container by domain
     *
     * @var array<array<string>>
     */
    protected $messages = [];

    /**
     * Constructor
     *
     * $config argument should contains the key translations giving
     * a key / values pairs of domain / path.
     *
     * Example :
     *
     * ```php
     * [
     *   'translations' => [
     *     'app' => '@app/messages'
     *   ]
       ]
       ```
     *
     * @param array<array<string>> $config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['translations'])) {
            foreach ($config['translations'] as $domain => $path) {
                $this->addTranslation($domain, $path);
            }
        }

        parent::__construct($config);
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
        $this->trigger('beforeAddTranslation', [$domain, $path]);
        $this->messages[$domain] = require Piko::getAlias($path) . '/' . Piko::get('language', 'en') . '.php';
    }

    /**
     * Translate a text.
     *
     * @param string $domain The translation domain, for instance 'app'.
     * @param string $text The text to translate.
     * @param array<string> $params Parameters substitution,
     *                                               eg. $this->translate('site', 'Hello {name}', ['name' => 'John']).
     *
     * @return string|null The translated text or the text itself if no translation was found (the text can be null).
     */
    public function translate(string $domain, ?string $text, array $params = []): ?string
    {
        $this->trigger('beforeTranslate', [&$domain, &$text, &$params]);

        if (is_string($text)) {
            $text = $this->messages[$domain][$text] ?? $text;

            foreach ($params as $k => $v) {
                $text = str_replace('{' . $k . '}', $v, $text);
            }
        }

        $this->trigger('afterTranslate', [$domain, &$text]);

        return $text;
    }
}
