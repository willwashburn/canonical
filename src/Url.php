<?php namespace Canonical;

/**
 * The response from a canonical tag search.
 *
 * The main reason this object exists is because some urls require a request
 * to find the true canonical url; namely when using the http-refresh tag we
 * want to be able to pass back a message that it requires refresh.
 */
class Url
{
    /**
     * @var bool
     */
    private $refresh_required;
    private $url;

    /**
     * e.g new Url('foo.com',false);
     *
     * @param      $url
     * @param bool $refresh_required
     */
    public function __construct($url, $refresh_required = false)
    {
        $this->url              = $url;
        $this->refresh_required = $refresh_required;
    }

    /**
     * The __toString() method allows a class to decide how it will react when
     * it is treated like a string. For example, what echo $url; will print.
     *
     * This method must return a string, as otherwise a fatal E_RECOVERABLE_ERROR
     * level error is emitted.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->withoutUtmParamsAndHashAnchors();
    }

    /**
     * This flag is passed in to note urls that are expected to be refreshed based
     * on how they were parsed from the HTML string
     *
     * @return bool
     */
    public function requiresRefresh()
    {
        return (bool) $this->refresh_required;
    }

    /**
     * Whatever we found on the page that we think is the canonical url
     *
     * @return string
     */
    public function beforeCleaning()
    {
        return $this->url;
    }

    /**
     * Some people add _utm params to their og:url urls and that is.. not very
     * helpful. This method will clean up what we find to make sure things
     * that should not be in the canonical url are not in the canonical url
     *
     * @return bool|null|string|string[]
     */
    public function withoutUtmParamsAndHashAnchors()
    {

        //remove utm params via regex replace, and cleanup and artifacts left behind afterwards
        $url = preg_replace('/\?$/', '', preg_replace('/&$/', '', preg_replace('/utm_[^&]+&?/i', '', $this->url)));

        //remove any hash anchors.
        $hash_pos = strpos($url, "#");
        if ($hash_pos !== false) {
            $url = substr($url, 0, $hash_pos);
        }

        return $url;
    }
}
