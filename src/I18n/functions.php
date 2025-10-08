<?php

/**
 * This file is part of Piko framework
 *
 * @copyright 2019-2022 Sylvain PHILIP
 * @license LGPL-3.0; see LICENSE.txt
 * @link https://github.com/piko-framework/i18n
 */

namespace Piko\I18n;

use RuntimeException;
use Piko\I18n;

/**
 * Proxy to I18n::translate method
 *
 * In order to use this function, an instance of I18n must be defined before.
 *
 * @param string $domain The translation domain, for instance 'app'.
 * @param string $text The text to translate.
 * @param array<string> $params Parameters substitution,
 *                                               eg. $this->translate('site', 'Hello {name}', ['name' => 'John']).
 * @throws RuntimeException if I18n instance doesn't exists
 * @return string The translated text or the text itself if no translation was found (the text can be null).
 *
 * @see I18n::setInstance()
 * @see I18n::translate()
 */
function __(string $domain, ?string $text, array $params = []): ?string
{
    $i18n = I18n::getInstance();

    if ($i18n === null) {
        throw new RuntimeException("To use the translate proxy __() function,
        an instance of I18n must be defined before. See I18n::setInstance()");
    }

    return $i18n->translate($domain, $text, $params);
}
