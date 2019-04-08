<?php namespace Canonical\Extractor;

use Canonical\Url;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Extracts a canonical url from the HTML tags in the body
 */
class HtmlTagExtractor implements Extractor
{

    private $crawler;
    /**
     * @var array
     */
    private $tags;

    /**
     * @param Crawler $crawler
     * @param array   $tags
     */
    public function __construct(Crawler $crawler = null, array $tags = [])
    {
        $this->crawler = $crawler;

        if (!$tags || !is_array($tags)) {
            $tags = $this->getDefaultTags();
        }

        $this->tags = $tags;
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
     *
     * @return false|Url
     */
    public function url($body)
    {
        // We want to make sure each time we use this the dom crawler doesn't
        // still have the content from the last time it was used
        //
        // There is a method to "clear" the dom crawler, but it is either buggy
        // in this version or doesn't work like that. Instead, we clone the
        // instance that was injected and use that.
        $crawler = clone $this->crawler;

        // Add the html to the body
        // probably should do some validation here
        $crawler->addContent($body);

        foreach ($this->tags as $type => $property) {
            $tag       = $property[0];
            $attribute = $property[1];

            $tag = $crawler->filter($tag);

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

                    return new Url($url, true);
                }

                return new Url($url, false);
            }
        }

        return false;
    }
}
