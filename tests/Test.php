<?php

/**
 * Class ExpandLinkTest
 */
class ExpandLinkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider  provider
     *
     * @param $file
     * @param $link
     */
    public function test_finds_correct_url($file, $link)
    {

        $canonical = new \WillWashburn\Canonical;

        $html = file_get_contents(__DIR__ . '/fixtures/' . $file);

        $this->assertEquals($link, $canonical->url($html));
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ['no_tag.html', false],
            ['og_and_link.html', 'http://blog.tailwindapp.com/tailwind-publisher-2-0/'],
        ];
    }

}