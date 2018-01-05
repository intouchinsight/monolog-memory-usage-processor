# Monolog Memory Usage Processor
[![Latest Version on Packagist](https://img.shields.io/packagist/v/lukewaite/monolog-memory-usage-processor.svg?style=flat-square)](https://packagist.org/packages/lukewaite/monolog-memory-usage-processor)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/lukewaite/monolog-memory-usage-processor/master.svg?style=flat-square)](https://travis-ci.org/lukewaite/monolog-memory-usage-processor)
[![Total Downloads](https://img.shields.io/packagist/dt/lukewaite/monolog-memory-usage-processor.svg?style=flat-square)](https://packagist.org/packages/lukewaite/monolog-memory-usage-processor)
[![Code Coverage][ico-coverage]][link-coverage]

## Usage

### Installing

This package can be installed with composer.

    $ composer require lukewaite/monolog-memory-usage-processor
    
### Using the Processor

    $memoryUsage = new MemoryUsageProcessor( true ); // Human formatted
    $memoryUsage = new MemoryUsageProcessor( false ); // Not human formatted
    

### What is this package for?

The [Memory Usage processors provided by the base Monolog package][base] only give you the option to
log with [`real_usage`][realusage] set to true or false. I have a need for both.

[base]: https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/MemoryUsageProcessor.php
[realusage]: http://php.net/manual/en/function.memory-get-usage.php

[ico-coverage]: https://img.shields.io/scrutinizer/coverage/g/lukewaite/monolog-memory-usage-processor/master.svg?style=flat-square
[link-coverage]: https://scrutinizer-ci.com/g/lukewaite/monolog-memory-usage-processor/?branch=master