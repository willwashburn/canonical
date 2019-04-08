<?php namespace Canonical;

use Canonical\Extractor\Extractor;
use Canonical\Extractor\HtmlTagExtractor;
use Canonical\Extractor\JavascriptRedirectExtractor;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Given a string of html, return the true canonical
 *
 * @author Will Washburn
 */
class Canonical
{
    /**
     * @param string      $body         The HTML you'd like to parse
     * @param Extractor[] $extractors   The extractors to use. Has sane defaults if you don't need to overwrite
     *
     * @return false|Url
     */
    public function url($body, array $extractors = [])
    {
        // An extractor is a class that can parse some string and return a canonical url.
        // If you aren't doing anything special, you don't need to pass in any. We include
        // sane defaults for you. You might, however, want to prioritize the order the tags
        // are parsed and so you might pass in a set of extractors to use instead.
        if (!$extractors || !is_array($extractors)) {
             $extractors = $this->defaultExtractors();
        }

        // We'll try each extractor until we find one that returns a url
        foreach ($extractors as $extractor) {
            $url = $extractor->url($body);

            if ($url) {
                return $url;
            }
        }

        // If we can't find anything, we'll just return false
        return false;
    }

    /**
     * @return array
     */
    private function defaultExtractors()
    {
        return [
            new HtmlTagExtractor(new Crawler()),
            new JavascriptRedirectExtractor(),
        ];
    }
}
