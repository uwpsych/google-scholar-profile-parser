<?php

/**
 * @file
 */

namespace GScholarProfileParser\DomCrawler;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Crawls a Google Scholar profile page.
 */
class ProfilePageCrawler
{

    public const GSCHOLAR_SCHEME = 'https';
    public const GSCHOLAR_HOSTNAME = 'scholar.google.com';

    private Crawler $crawler;

    public function __construct(HttpBrowser $browser, string $profileId)
    {
        $url = sprintf(
            '%s://%s/citations?user=%s&pagesize=1000&sortby=pubdate&hl=en',
            self::GSCHOLAR_SCHEME,
            self::GSCHOLAR_HOSTNAME,
            $profileId
        );

        $this->crawler = $browser->request('GET', $url);
    }

    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    public static function getSchemeAndHostname(): string
    {
        return self::GSCHOLAR_SCHEME . '://' . self::GSCHOLAR_HOSTNAME;
    }
}
