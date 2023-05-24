<?php

require __DIR__ . '/../vendor/autoload.php';

use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use GScholarProfileParser\Entity\Statistics;
use GScholarProfileParser\Parser\StatisticsParser;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

/** @var HttpBrowser $browser */
$browser = new HttpBrowser(HttpClient::create());

/** @var ProfilePageCrawler $crawler */
$crawler = new ProfilePageCrawler($browser, '8daWuo4AAAAJ'); // the second parameter is the scholar's profile id

/** @var StatisticsParser $parser */
$parser = new StatisticsParser($crawler->getCrawler());

/** @var Statistics $statistics */
$statistics = new Statistics(...$parser->parse());

$nbCitationsPerYear = $statistics->nbCitationsPerYear;
$sinceYear = $statistics->sinceYear;

$nbCitationsSinceYear = 0;
foreach ($nbCitationsPerYear as $year => $nbCitations) {
    if ($year >= $sinceYear) {
        $nbCitationsSinceYear += $nbCitations;
    }
}

// display statistics
echo sprintf("           All\t%4d\n", $sinceYear);
echo sprintf("Citations: %4d\t%4d\n", $statistics->nbCitations, $nbCitationsSinceYear);
echo sprintf("h-index  : %4d\t%4d\n", $statistics->hIndex, $statistics->hIndexSince);
echo sprintf("i10-index: %4d\t%4d\n", $statistics->i10Index, $statistics->i10IndexSince);
echo "\n";
echo implode("\t", array_keys($nbCitationsPerYear));
echo "\n";
echo implode("\t", array_values($nbCitationsPerYear));
echo "\n";
