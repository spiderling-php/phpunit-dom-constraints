<?php

namespace SP\PhpunitDomConstraints;

use DOMElement;
use DOMXPath;
use Symfony\Component\CssSelector\CssSelector;
use PHPUnit_Framework_Constraint;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class MatchesSelector extends PHPUnit_Framework_Constraint
{
    private $cssSelector;

    /**
     * @param string $cssSelector
     */
    public function __construct($cssSelector)
    {
        parent::__construct();

        $this->cssSelector = $cssSelector;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param  mixed $other
     * @return bool
     */
    public function matches($other)
    {
        if ($other instanceof DOMElement) {
            $xpathSelector = CssSelector::toXPath($this->cssSelector, '//');
            $xpath = new DOMXPath($other->ownerDocument);

            foreach ($xpath->query($xpathSelector) as $node) {
                if ($node === $other) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return 'is "'.$this->cssSelector.'"';
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * This works specifically to make a nice representation of a DOMElement
     *
     * @param  mixed  $other Evaluated value or object.
     * @return string
     */
    protected function failureDescription($other)
    {
        return Converter::describeDOMElement($other).' '.$this->toString();
    }
}
