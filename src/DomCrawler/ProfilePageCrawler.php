<?php

namespace GScholarProfileParser\DomCrawler;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Crawls a Google Scholar profile page.
 */
class ProfilePageCrawler
{
    public const GSCHOLAR_URL = 'https://scholar.google.com';

    private Crawler $crawler;

    public function __construct(string $profileId, int $pageSize = 50)
    {
        $browser = new HttpBrowser(HttpClient::create());
        $this->crawler = $browser->request('GET', self::getSchemeAndHostname()."/citations?user={$profileId}&pagesize={$pageSize}&sortby=pubdate&hl=en");
    }

    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    public static function getSchemeAndHostname(): string
    {
        return self::GSCHOLAR_URL;
    }
}
