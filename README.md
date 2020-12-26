# Theme Suite Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/theme-suite/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

**Theme Suite** is an extended collection of partial drivers, metabox drivers ... dedicated to building apps.

## Installation

```bash
composer require pollen-solutions/theme-suite
```

## Pollen Framework Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \Pollen\ThemeSuite\ThemeSuiteServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/theme-suite.php
// @see /vendor/pollen-solutions/theme-suite/resources/config/theme-suite.php
return [
      //...

      // ...
];
```
