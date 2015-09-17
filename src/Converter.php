<?php

namespace SP\PhpunitDomConstraints;

use DOMElement;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Converter
{
    /**
     * Convert a css class list
     *
     * e.g. class1 class2 class3
     *
     * to a normalized array of classes
     *
     * @param  string $classString
     * @return array
     */
    public static function parseClasses($classString)
    {
        return array_values(array_filter(explode(' ', trim((string) $classString))));
    }

    /**
     * Convert a dom element to a textual representation.
     * Shows tag name, id and classes
     *
     * @param  mixed $other
     * @return string
     */
    public static function describeDOMElement($other)
    {
        if ($other instanceof DOMElement) {
            $tag = $other->tagName;

            $id = $other->getAttribute("id");
            $id = $id ? '#'.$id : null;

            $classes = Converter::parseClasses($other->getAttribute("class"));
            $classes = $classes ? '.'.join('.', $classes) : null;

            return $tag.$id.$classes;
        } else {
            return '[unknown]';
        }
    }
}
