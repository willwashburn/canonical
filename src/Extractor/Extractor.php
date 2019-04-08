<?php namespace Canonical\Extractor;

use Canonical\Url;

/**
 * Interface for how we parse a string and get back a canonical url from
 *
 * @package Canonical\Extractor
 */
interface Extractor
{

    /**
     * For a given string, returns the most likely url
     *
     * @param string $string
     *
     * @return bool|Url
     */
    public function url($string);
}
