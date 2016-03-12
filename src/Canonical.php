<?php namespace WillWashburn;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Given a string of html, return the true canonical url from various tags
 *
 * @author  Will Washburn
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
            ['meta[property="og:url"]', 'content'],
            ['link[rel="canonical"]', 'href'],
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
        if ( empty($tags) OR !is_array($tags) ) {
            $tags = $this->getDefaultTags();
        }

        // Add the html to the body
        // probably should do some validation here
        $this->crawler->addContent($body);

        foreach ( $tags as list( $tag, $attribute ) ) {

            $tag = $this->crawler->filter($tag);

            if ( count($tag) == 0 ) {
                continue;
            }

            $url = $tag->attr($attribute);

            if ( !empty($url) ) {
                return $url;
            }
        }

        return false;
    }

}