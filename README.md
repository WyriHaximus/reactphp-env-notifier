# ReactPHP environment variable notifier

Notifies when an environment variable changes

![Continuous Integration](https://github.com/wyrihaximus/reactphp-env-notifier/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/wyrihaximus/react-env-notifier/v/stable.png)](https://packagist.org/packages/wyrihaximus/react-env-notifier)
[![Total Downloads](https://poser.pugx.org/wyrihaximus/react-env-notifier/downloads.png)](https://packagist.org/packages/wyrihaximus/react-env-notifier/stats)
[![Type Coverage](https://shepherd.dev/github/WyriHaximus/reactphp-env-notifier/coverage.svg)](https://shepherd.dev/github/WyriHaximus/reactphp-env-notifier)
[![License](https://poser.pugx.org/wyrihaximus/react-env-notifier/license.png)](https://packagist.org/packages/wyrihaximus/react-env-notifier)

# Installation

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/react-env-notifier
```

# Usage

```php
use WyriHaximus\React\Env\Notifier\EnvVar;
use WyriHaximus\React\Env\Notifier\Notifier;

Notifier::listen('NAME')->subscribe(function (EnvVar $envVar) {
    echo $envVar->name, ': ', $envVar->value, PHP_EOL; // Echo's NAME: VALUE
});

putenv('NAME=VALUE');
```

# License

The MIT License (MIT)

Copyright (c) 2022 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
