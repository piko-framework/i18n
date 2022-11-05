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
 * Event emitted before to translate a text
 *
 * @author Sylvain Philip <contact@sphilip.com>
 */
class BeforeTranslateEvent extends Event
{
    /**
     * The translation domain.
     *
     * @var string
     */
    public $domain;

    /**
     * The text to translate.
     *
     * @var string|null
     */
    public $text;

    /**
     * The translation parameters used to substitute translation variables.
     *
     * @var array<string, string>
     */
    public $params;

    /**
     * @param string $domain The translation domain
     * @param string|null $text The text to translate
     * @param array<string, string> $params The translation parameters used to substitute translation variables
     */
    public function __construct(string $domain, ?string $text, array $params)
    {
        $this->domain = $domain;
        $this->text = $text;
        $this->params = $params;
    }
}
