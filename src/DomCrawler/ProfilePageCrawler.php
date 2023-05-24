<?php

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

    public function __construct(HttpBrowser $browser, string $profileId, int $pageSize = 1000)
    {
        $this->crawler = $browser->request('GET', self::getSchemeAndHostname()."/citations?user={$profileId}&pagesize={$pageSize}&sortby=pubdate&hl=en");
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
