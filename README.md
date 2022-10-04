# Piko I18n

[![build](https://github.com/piko-framework/i18n/actions/workflows/php.yml/badge.svg)](https://github.com/piko-framework/i18n/actions/workflows/php.yml)
[![Coverage Status](https://coveralls.io/repos/github/piko-framework/i18n/badge.svg?branch=main)](https://coveralls.io/github/piko-framework/i18n?branch=main)

A minimal internationalization component which can be used in a piko application or standalone.

# Installation

It's recommended that you use Composer to install Piko I18n.

```bash
composer require piko/i18n
```

# Usage

Application structure example :

```
App root
  |__messages
    |__fr.php
  |__index.php
```

fr.php :

```php
return [
    'Translation test' => 'Test de traduction',
    'Hello {name}' => 'Bonjour {name}',
];
```

## Usage in a piko application

```bash
composer require piko/framework
```

index.php :

```php

use piko\Application;
use piko\Piko;

require('vendor/autoload.php');

$config = [
    'basePath' => __DIR__,
    'language' => 'fr',
    'components' => [
        'i18n' => [
            'class' => 'piko\i18n',
            'translations' => [
                'app' => '@app/tests/messages'
            ]
        ],
    ],
];

$app = new Application($config);

Piko::set('language', $app->language);

$i18n = Piko::get('i18n');

echo $i18n->translate('app', 'Translation test') . '<br>'; // Test de traduction
echo $i18n->translate('app', 'Hello {name}', ['name' => 'John']) . '<br>' ; // Bonjour John

// Using the proxy function __() :
echo __('app', 'Translation test') . '<br>'; // Test de traduction
echo __('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;  // Bonjour John
```

## Usage in a standalone application

```php
$config = [
    'translations' => [
        'app' => '@app/tests/messages'
    ]
];

use piko\I18n;
use piko\Piko;

require('vendor/autoload.php');

Piko::set('language', 'fr');
Piko::setAlias('@app', __DIR__);

$i18n = new I18n($config);

Piko::set('i18n', $i18n);

echo $i18n->translate('app', 'Translation test') . '<br>';
echo $i18n->translate('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;

// Using the proxy function __() :
echo __('app', 'Translation test') . '<br>';
echo __('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;

```
