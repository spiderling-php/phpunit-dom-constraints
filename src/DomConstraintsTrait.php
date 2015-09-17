<?php

namespace SP\PhpunitDomConstraints;

use DOMElement;
use PHPUnit_Framework_Constraint_And;
use PHPUnit_Framework_Assert;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait DomConstraintsTrait
{
    /**
     * Returns a MatchesSelector matcher object.
     *
     * @param  string          $selector
     * @return MatchesSelector
     */
    public function matchesSelector($selector)
    {
        return new MatchesSelector($selector);
    }

    /**
     * Asserts that a dom element matches a specified selector
     *
     * @param string $selector
     * @param string            $message
     */
    public function assertMatchesSelector($selector, DOMElement $element, $message = '')
    {
        return PHPUnit_Framework_Assert::assertThat($element, $this->matchesSelector($selector), $message);
    }

    /**
     * Asserts that an array has a specified subset.
     *
     * @param string $selector
     * @param string            $message
     */
    public function assertNotMatchesSelector($selector, DOMElement $element, $message = '')
    {
        return PHPUnit_Framework_Assert::assertThat($element, PHPUnit_Framework_Assert::logicalNot($this->matchesSelector($selector)), $message);
    }
}
