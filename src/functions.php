<?php

/**
 * This file is part of Piko framework
 *
 * @copyright 2019-2022 Sylvain PHILIP
 * @license LGPL-3.0; see LICENSE.txt
 * @link https://github.com/piko-framework/i18n
 */

use piko\Piko;
use piko\I18n;

/**
 * Proxy to I18n::translate method
 *
 * @param string $domain The translation domain, for instance 'app'.
 * @param string $text The text to translate.
 * @param array<string> $params Parameters substitution,
 *                                               eg. $this->translate('site', 'Hello {name}', ['name' => 'John']).
 *
 * @throws RuntimeException
 * @return string The translated text or the text itself if no translation was found (the text can be null).
 *
 * @see I18n::translate()
 */
function __(string $domain, ?string $text, array $params = []): ?string
{
    $i18n = Piko::get('i18n');

    if (!$i18n instanceof I18n) {
        throw new RuntimeException('i18n must be instance of piko\I18n');
    }

    return $i18n->translate($domain, $text, $params);
}
