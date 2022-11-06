# Piko I18n

[![build](https://github.com/piko-framework/i18n/actions/workflows/php.yml/badge.svg)](https://github.com/piko-framework/i18n/actions/workflows/php.yml)
[![Coverage Status](https://coveralls.io/repos/github/piko-framework/i18n/badge.svg?branch=main)](https://coveralls.io/github/piko-framework/i18n?branch=main)

A minimal internationalization component which can be used in a piko application or standalone.

## Installation

It's recommended that you use Composer to install Piko I18n.

```bash
composer require piko/i18n
```

## Usage

In order to use the I18n component, translations have to be stored in PHP 
files that return a key-value pair array of translations. Keys are strings to translate 
and values are corresponding translated strings.

Example of translation file *fr.php* :

```php
return [
    'Translation test' => 'Test de traduction',
    'Hello {name}' => 'Bonjour {name}',
];
```

Application structure example:

```
App root
  |__messages
    |__fr.php
  |__index.php
```

## Usage in a piko application

index.php :

```php
use Piko\Application;
use function Piko\I18n\__;

require('vendor/autoload.php');

$config = [
    'basePath' => __DIR__,
    'components' => [
        'Piko\I18n' => [
            'construct' => [
                ['app' => '@app/messages'],
                'fr'
            ]
        ],
    ],
];

$app = new Application($config);

$i18n = $app->getComponent('Piko\I18n');

echo $i18n->translate('app', 'Translation test') . '<br>'; // Test de traduction
echo $i18n->translate('app', 'Hello {name}', ['name' => 'John']) . '<br>' ; // Bonjour John

// Using the proxy function __() :
echo __('app', 'Translation test') . '<br>'; // Test de traduction
echo __('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;  // Bonjour John
```

## Usage in a standalone script

```php
use Piko\I18n;
use function Piko\I18n\__;

require('vendor/autoload.php');

$i18n = new I18n(['app' => __DIR__ . '/messages'], 'fr');

echo $i18n->translate('app', 'Translation test') . '<br>';
echo $i18n->translate('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;

// Using the proxy function __() :

echo __('app', 'Translation test') . '<br>';
echo __('app', 'Hello {name}', ['name' => 'John']) . '<br>' ;

```
