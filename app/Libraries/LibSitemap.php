<?php

namespace App\Libraries;

class LibSitemap
{
    public $urls = [];
    public $changefreqs = [
        'always',
        'hourly',
        'daily',
        'weekly',
        'monthly',
        'yearly',
        'never'
    ];

    public function __construct()
    {

    }
    /**
     * Add an item to the array of items for which the sitemap will be generated
     *
     * @param string $loc URL of the page. This URL must begin with the protocol (such as http) and end with a trailing slash, if your web server requires it. This value must be less than 2,048 characters.
     * @param string $lastmod The date of last modification of the file. This date should be in W3C Datetime format. This format allows you to omit the time portion, if desired, and use YYYY-MM-DD.
     * @param string $changefreq How frequently the page is likely to change. This value provides general information to search engines and may not correlate exactly to how often they crawl the page.
     * @param number $priority The priority of this URL relative to other URLs on your site. Valid values range from 0.0 to 1.0. This value does not affect how your pages are compared to pages on other sites—it only lets the search engines know which pages you deem most important for the crawlers.
     * @access public
     * @return boolean
     */
    public function add($loc, $lastmod = null, $changefreq = null, $priority = null, $news = null)
    {
        // Do not continue if the changefreq value is not a valid value
        if ($changefreq !== null && !in_array($changefreq, $this->changefreqs)) {
            show_error('Unknown value for changefreq: '.$changefreq);
            return false;
        }
        // Do not continue if the priority value is not a valid number between 0 and 1
        if ($priority !== null && ($priority < 0 || $priority > 1)) {
            show_error('Invalid value for priority: '.$priority);
            return false;
        }
        $item = new \stdClass();
        $item->loc = $loc;
        $item->lastmod = $lastmod;
        $item->changefreq = $changefreq;
        $item->priority = $priority;
        $item->news = $news;
        $this->urls[] = $item;

        return true;
    }

    /**
     * Generate the sitemap file and replace any output with the valid XML of the sitemap
     *
     * @param string $type Type of sitemap to be generated. Use 'urlset' for a normal sitemap. Use 'sitemapindex' for a sitemap index file.
     * @access public
     * @return void
     */
    public function output($type = 'urlset', $attrs = null)
    {

        $attrs = !empty($attrs) ? $attrs : 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><'. $type . ' ' . $attrs . ' />');
        //$xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        //$xml->addAttribute('xmlns:xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        //$xml->addAttribute('xmlns:xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');


        if ($type == 'urlset') {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('url');
                $child->addChild('loc', strtolower($url->loc));

                if (!empty($url->news)) {
                    $child_news = $child->addChild('news:news', null, "http://www.google.com/schemas/sitemap-news/0.9");

                    $child_news_publication = $child_news->addChild('news:publication', null, "http://www.google.com/schemas/sitemap-news/0.9");
                    if (isset($url->news['publication']['name'])) {
                        $child_news_publication->addChild('news:name', $url->news['publication']['name'], "http://www.google.com/schemas/sitemap-news/0.9");
                    }
                    if (isset($url->news['publication']['language'])) {
                        $child_news_publication->addChild('news:language', $url->news['publication']['language'], "http://www.google.com/schemas/sitemap-news/0.9");
                    }

                    if (isset($url->news['publication_date'])) {
                        $child_news->addChild('news:publication_date', $url->news['publication_date'], "http://www.google.com/schemas/sitemap-news/0.9");
                    }
                    if (isset($url->news['title'])) {
                        $child_news->addChild('news:title', $url->news['title'], "http://www.google.com/schemas/sitemap-news/0.9");
                    }
                    if (isset($url->news['keywords'])) {
                        $child_news->addChild('news:keywords', $url->news['keywords'], "http://www.google.com/schemas/sitemap-news/0.9");
                    }

                } else {
                    if (isset($url->lastmod)) {
                        $child->addChild('lastmod', $url->lastmod);
                    }
                    if (isset($url->changefreq)) {
                        $child->addChild('changefreq', $url->changefreq);
                    }
                    if (isset($url->priority)) {
                        $child->addChild('priority', number_format($url->priority, 1));
                    }
                }

            }
        } elseif ($type == 'sitemapindex') {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('sitemap');
                $child->addChild('loc', strtolower($url->loc));
                if (isset($url->lastmod)) {
                    $child->addChild('lastmod', $url->lastmod);
                }
            }
        }
        //$xml->asXml('sitemap.xml');
        return $xml->asXml();
    }

    /**
     * Clear all items in the sitemap to be generated
     *
     * @access public
     * @return boolean
     */
    public function clear()
    {
        $this->urls = [];
        return true;
    }

}
