Phpunit Dom Constraints
=======================

[![Build Status](https://travis-ci.org/spiderling-php/phpunit-dom-constraints.png?branch=master)](https://travis-ci.org/spiderling-php/phpunit-dom-constraints)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spiderling-php/phpunit-dom-constraints/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spiderling-php/phpunit-dom-constraints/)
[![Code Coverage](https://scrutinizer-ci.com/g/spiderling-php/phpunit-dom-constraints/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/spiderling-php/phpunit-dom-constraints/)
[![Latest Stable Version](https://poser.pugx.org/spiderling-php/phpunit-dom-constraints/v/stable.png)](https://packagist.org/packages/spiderling-php/phpunit-dom-constraints)

PHPUnit extension for testing dom documents

Instalation
-----------

Install via composer

```
composer require --dev spiderling-php/phpunit-dom-constraints
```

Usage
-----

This extension allows to check if a DOMElement matches a particular css selector

```php
class TestCaseTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    public function testTest()
    {
        $document = new DOMDocument();
        $document->load('Some file');

        $element = $document->getElementById('some id');

        // Here is the test you can now perform
        $this->assertMatchesSelector('div.some-class', $element, 'This should match');

        // You can do even more complex selects
        $this->assertMatchesSelector('ul li > #test.some-class[disabled]', $element, 'This should match');
    }
}
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
