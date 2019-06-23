# messagebus-logging-middleware

[![Travis CI](https://api.travis-ci.org/qlimix/messagebus-logging-middleware.svg?branch=master)](https://travis-ci.org/qlimix/messagebus-logging-middleware)
[![Coveralls](https://img.shields.io/coveralls/github/qlimix/messagebus-logging-middleware.svg)](https://coveralls.io/github/qlimix/messagebus-logging-middleware)
[![Packagist](https://img.shields.io/packagist/v/qlimix/messagebus-logging-middleware.svg)](https://packagist.org/packages/qlimix/messagebus-logging-middleware)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/qlimix/messagebus-logging-middleware/blob/master/LICENSE)

Logging messages going through the messagebus with middleware.

## Install

Using Composer:

~~~
$ composer require qlimix/messagebus-logging-middleware
~~~

## usage
```php
<?php

use Qlimix\MessageBus\MessageBus\Middleware\MessageLoggerMiddleware;

$messageLogger = new FooBarMessageLogger();
$messageLoggerMiddleware = new MessageLoggerMiddleware($messageLogger);
```

## Testing
To run all unit tests locally with PHPUnit:

~~~
$ vendor/bin/phpunit
~~~

## Quality
To ensure code quality run grumphp which will run all tools:

~~~
$ vendor/bin/grumphp run
~~~

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
