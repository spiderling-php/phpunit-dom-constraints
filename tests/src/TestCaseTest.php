<?php

namespace SP\PhpunitDomConstraints\Test;

use PHPUnit_Framework_TestCase;
use SP\PhpunitDomConstraints\DomConstraintsTrait;
use DOMDocument;

/**
 * @coversDefaultClass SP\PhpunitDomConstraints\DomConstraintsTrait
 */
class TestCaseTest extends PHPUnit_Framework_TestCase
{
    use DomConstraintsTrait;

    /**
     * @covers ::matchesSelector
     */
    public function testConstraints()
    {
        $this->assertInstanceOf(
            'SP\PhpunitDomConstraints\MatchesSelector',
            $this->matchesSelector('test')
        );
    }

    /**
     * @covers ::assertMatchesSelector
     * @covers ::assertNotMatchesSelector
     */
    public function testAsserts()
    {
        $doc = new DOMDocument();
        $doc->loadHTML('
            <div id="test" data-test="some"></div>
            <button id="test2" class="my" type="submit" value="test" disabled></button>
        ');

        $this->assertMatchesSelector('div#test', $doc->getElementById('test'));
        $this->assertNotMatchesSelector('div#other', $doc->getElementById('test'));

        $this->assertMatchesSelector('#test2', $doc->getElementById('test2'));
        $this->assertMatchesSelector('button.my[type="submit"][value="test"]', $doc->getElementById('test2'));
        $this->assertNotMatchesSelector('button.my[type="my"]', $doc->getElementById('test2'));
    }
}
