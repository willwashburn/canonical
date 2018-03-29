<?php namespace WillWashburn;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Given a string of html, return the true canonical url from various tags
 *
 * @author Will Washburn
 */
class Canonical
{
    private $crawler;

    /**
     * Canonical constructor.
     *
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler = null)
    {
        $this->crawler = is_null($crawler) ? new Crawler : $crawler;
    }

    /**
     * The tags to look for (in order of preference) and their attr's to
     * use to get the value
     *
     * @return array
     */
    protected function getDefaultTags()
    {
        return [
            'canonical'    => ['link[rel="canonical"]', 'href'],
            'og'           => ['meta[property="og:url"]', 'content'],
            'twitter'      => ['meta[name="twitter:url"]', 'content'],
            'http-refresh' => ['meta[http-equiv="refresh"]', 'content'],
        ];
    }

    /**
     * @param       $body
     * @param array $tags
     *
     * @return false|string
     */
    public function url($body, array $tags = [])
    {
        if (!$tags or !is_array($tags)) {
            $tags = $this->getDefaultTags();
        }

        // Make sure each time we use this the dom crawler is clear
        $this->crawler->clear();

        // Add the html to the body
        // probably should do some validation here
        $this->crawler->addContent($body);

        foreach ($tags as $type => $property) {
            $tag       = $property[0];
            $attribute = $property[1];

            $tag = $this->crawler->filter($tag);

            if (count($tag) == 0) {
                continue;
            }

            $url = $tag->attr($attribute);

            if ($url) {
                /*
                 * If we are using the http-refresh tag, then we need to rip out
                 * the actual url from the tag.
                 *
                 * A http-refresh tag generally looks like this:
                 *   <meta http-equiv="refresh" content="3;url=http://foobar.com" />
                 *
                 * We want to only have the part after the url= piece.
                 */
                if ($type == 'http-refresh') {
                    $re = '/url=(.*)/i';

                    preg_match($re, $url, $matches);

                    $url = $matches[1];

                    // If this fails, we try a different tag
                    if (!$url) {
                        continue;
                    }
                }

                return $this->cleanUrl($url);
            }
        }

        return false;
    }

    /**
     * Some people add _utm params to their og:url urls and that is.. not very
     * helpful. This method will clean up what we find to make sure things
     * that should not be in the canonical url are not in the canonical url
     *
     * @param $url
     *
     * @return bool|null|string|string[]
     */
    private function cleanUrl($url)
    {
        //remove utm params via regex replace, and cleanup and artifacts left behind afterwards
        $url = preg_replace('/\?$/', '', preg_replace('/&$/', '', preg_replace('/utm_[^&]+&?/i', '', $url)));

        //remove any hash anchors.
        $hash_pos = strpos($url, "#");
        if ($hash_pos !== false) {
            $url = substr($url, 0, $hash_pos);
        }

        return $url;
    }
}
