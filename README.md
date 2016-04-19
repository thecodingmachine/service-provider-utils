[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/service-provider-utils/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/service-provider-utils/?branch=1.0)
[![Build Status](https://travis-ci.org/thecodingmachine/service-provider-utils.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/service-provider-utils)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/service-provider-utils/badge.svg?branch=1.0&service=github)](https://coveralls.io/github/thecodingmachine/service-provider-utils?branch=1.0)

# Service-provider utils

This package contains a set of tools to work with [container-interop's service-providers](https://github.com/container-interop/definition-interop/).

## Installation

You can install this package through Composer:

```json
{
    "require": {
        "thecodingmachine/service-provider-utils": "~1.0"
    }
}
```

The packages adheres to the [SemVer](http://semver.org/) specification, and there will be full backward compatibility
between minor versions.

## Usage

This package contains a single utility method that analyses a factory (i.e. a callable) and returns if the second argument (the `$previous` argument) is used or not.

```php
// $previous is not used in this callable
$callable = function(ContainerInterface $container, $previous) {
    return new MyService();
});

$factoryAnalyser = new FactoryAnalyzer();
$isPreviousUsed = $factoryAnalyser->isPreviousArgumentUsed($callable);
// $isPreviousUsed === false
```

Note: this function can sometimes return false positives, in particular if your body contains calls to `func_get_args` or refences by variable name (`$$foo`). It should however never return false negatives.
