<?php

namespace GScholarProfileParser\Parser;

use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @codeCoverageIgnore
 */
abstract class BaseParser
{
    public function __construct(protected $crawler)
    {
        $this->crawler = $crawler instanceof Crawler ? $crawler : $crawler->getCrawler();
    }
}
