<?php

class ExpandLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  provider
     *
     * @param $file
     * @param $link
     * @param $requires_refresh
     */
    public function test_finds_correct_url($file, $link, $requires_refresh)
    {

        $canonical = new \Canonical\Canonical;

        $html = file_get_contents(__DIR__ . '/fixtures/' . $file);

        $url = $canonical->url($html);

        $this->assertEquals($link, $url);
        if ($url) {
            $this->assertEquals($requires_refresh, $url->requiresRefresh());
        }
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ['no_tag.html', false, false],
            ['og_and_link.html', 'http://blog.tailwindapp.com/tailwind-publisher-2-0/', false],
            ['partial.html', 'http://blog.tailwindapp.com/tailwind-publisher-2-0/', false],
            ['utms.html', 'https://www.etsy.com/listing/237462283/baby-carrying-jacket-baby-carrier-coat', false],
            ['refresh_tag.html', 'http://www.awin1.com/cread.php?awinmid=6220&awinaffid=202819&clickref=3083594506&p=https%3A%2F%2Fwww.etsy.com%2Flisting%2F539434803%2Fgirl-woodland-nursery-nursery-decor-girl%3Fga_order%3Dmost_relevant%26ga_search_type%3Dall%26ga_view_type%3Dgallery%26ga_search_query%3Dbaby%2520girl%2520nursery%26ref%3Dsc_gallery_1%26plkey%3D2c352cb72e3b0737c849359d06df10af4cb14aff%3A539434803%26source%3Daw%26', true],
        ];
    }


    public function test_url_object_works()
    {

        $string = 'http://foobar.com';

        $url = new \Canonical\Url($string, $refresh_required = false);
        $this->assertFalse($url->requiresRefresh());

        // Make sure casting to string works
        $this->assertEquals($string, $url);


        $url = new \Canonical\Url($string, $refresh_required = true);
        $this->assertTrue($url->requiresRefresh());

        // Make sure casting to string works
        $this->assertEquals($string, $url);
    }
}
