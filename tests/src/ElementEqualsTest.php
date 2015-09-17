<?php

namespace SP\PhpunitDomConstraints\Test;

use PHPUnit_Framework_TestCase;
use SP\PhpunitDomConstraints\MatchesSelector;
use DOMDocument;

/**
 * @coversDefaultClass SP\PhpunitDomConstraints\MatchesSelector
 */
class MatchesSelectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::failureDescription
     */
    public function testUse()
    {
        $doc = new DOMDocument();
        $doc->loadHTML('
            <div id="test" data-test="some"></div>
            <button id="test2" class="my" type="submit" value="test" disabled></button>
        ');

        $this->assertThat(
            $doc->getElementById('test'),
            new MatchesSelector('div#test'),
            'Find using id'
        );

        $this->assertThat(
            $doc->getElementById('test2'),
            new MatchesSelector('button#test2.my'),
            'Find using id and class'
        );

        $this->assertThat(
            $doc->getElementById('test2'),
            new MatchesSelector('button[type="submit"]'),
            'Find by attributes'
        );

        $this->assertThat(
            $doc->getElementById('test2'),
            new MatchesSelector('button[type=submit]'),
            'Find by attributes with alternate syntax'
        );

        $this->assertThat(
            $doc->getElementById('test2'),
            $this->logicalNot(new MatchesSelector('div#other')),
            'Make sure tag is not present'
        );

        $this->assertThat(
            $doc->getElementById('test'),
            $this->logicalNot(new MatchesSelector('button.other')),
            'Make sure tag is not present'
        );

        $this->assertThat(
            $doc->getElementById('test'),
            $this->logicalNot(new MatchesSelector('button[type="other"]')),
            'Make sure tag is not present'
        );

        $this->assertThat(
            'test',
            $this->logicalNot(new MatchesSelector('div')),
            'Failes if not a tag'
        );
    }

    /**
     * @covers ::__construct
     */
    public function testArgumentException()
    {
        $doc = new DOMDocument();
        $doc->loadHTML('
            <div id="test" data-test="some"></div>
            <button id="test2" class="my" type="submit" value="test" disabled></button>
        ');

        $this->setExpectedException(
            'Symfony\Component\CssSelector\Exception\SyntaxErrorException',
            'Unclosed/invalid string at 12.'
        );

        $constraint = new MatchesSelector('button[type="submit]');
        $constraint->evaluate($doc->getElementById('test'));
    }

    /**
     * @covers ::failureDescription
     */
    public function testFailureDescription()
    {
        $constraint = new MatchesSelector('button[type="submit]');

        $doc = new DOMDocument();
        $doc->loadHTML('<div id="test" class="tests class"></div>');

        $this->setExpectedException(
            'PHPUnit_Framework_ExpectationFailedException',
            'Failed asserting that div#test.tests.class is "button#test2.my".'
        );

        $constraint = new MatchesSelector('button#test2.my');

        $constraint->evaluate($doc->getElementById('test'));
    }

    /**
     * @covers ::failureDescription
     */
    public function testFailureDescriptionUnknown()
    {
        $this->setExpectedException(
            'PHPUnit_Framework_ExpectationFailedException',
            'Failed asserting that [unknown] is "button#test2.my".'
        );

        $constraint = new MatchesSelector('button#test2.my');

        $constraint->evaluate('test');

    }
}
