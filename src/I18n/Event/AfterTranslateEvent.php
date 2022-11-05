<?php

/**
 * This file is part of Piko Framework
 *
 * @copyright 2019-2022 Sylvain Philip
 * @license LGPL-3.0-or-later; see LICENSE.txt
 * @link https://github.com/piko-framework/db-record
 */

declare(strict_types=1);

namespace Piko\I18n\Event;

use Piko\Event;

/**
 * Event emitted after a text was translated
 *
 * @author Sylvain Philip <contact@sphilip.com>
 */
class AfterTranslateEvent extends Event
{
    /**
     * The translated domain
     *
     * @var string
     */
    public $domain;

    /**
     * The translated text
     *
     * @var string|null
     */
    public $text;

    /**
     * @param string $domain The translated domain
     * @param string $text|null The translated text
     */
    public function __construct(string $domain, ?string $text)
    {
        $this->domain = $domain;
        $this->text = $text;
    }
}
