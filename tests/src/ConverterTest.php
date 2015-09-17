<?php

namespace SP\PhpunitDomConstraints\Test;

use PHPUnit_Framework_TestCase;
use SP\PhpunitDomConstraints\Converter;
use DOMDocument;

/**
 * @coversDefaultClass SP\PhpunitDomConstraints\Converter
 */
class ConverterTest extends PHPUnit_Framework_TestCase
{
    public function dataParseClasses()
    {
        return [
            ['', []],
            ['test', ['test']],
            ['test test2', ['test', 'test2']],
            [' test orange  green  ', ['test', 'orange', 'green']],
        ];
    }

    /**
     * @covers ::describeDOMElement
     */
    public function testDescribeDOMElement()
    {
        $doc = new DOMDocument();
        $doc->loadHTML('
            <div id="test"></div>
            <button id="test2" class="my" type="submit" value="test" disabled></button>
        ');

        $this->assertEquals(
            'div#test',
            Converter::describeDOMElement($doc->getElementById('test')),
            'Describe element with id'
        );

        $this->assertEquals(
            'button#test2.my',
            Converter::describeDOMElement($doc->getElementById('test2')),
            'Describe element with different attributes'
        );

        $this->assertEquals(
            '[unknown]',
            Converter::describeDOMElement('test'),
            'Describe empty element'
        );
    }

}
