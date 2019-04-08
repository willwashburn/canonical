<?php namespace Canonical\Extractor;

use Canonical\Url;

/**
 * Extracts a canonical url from the string looking for a javascript redirect
 */
class JavascriptRedirectParser implements Extractor
{
    /**
     * @param       $body
     *
     * @return false|Url
     */
    public function url($body)
    {
        $re = '/window.location(\.assign|\.replace)\(["|\'](.+)["|\']/i';
        preg_match_all($re, $body, $matches);

        if (!empty($matches[2])) {
            return new Url($matches[2][0], true);
        }

        return false;
    }
}
